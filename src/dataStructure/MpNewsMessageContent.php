<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/9
	 * Time: 15:16
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class MpNewsMessageContent
	 *
	 * @property string $msgtype   消息类型，此时固定为：mpnews
	 * @property array  $articles  图文消息，一个图文消息支持1到8条图文
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MpNewsMessageContent
	{
		const MSG_TYPE = 'mpnews';

		/**
		 * @param array $arr
		 *
		 * @return MpNewsMessageContent
		 */
		public static function parseFromArray ($arr)
		{
			$mpNewsMesssageContent = new MpNewsMessageContent();

			$mpNewsMesssageContent->articles = Utils::arrayGet($arr, 'articles');

			return $mpNewsMesssageContent;
		}

		/**
		 * @param MpNewsMessageContent $mpNewsMesssageContent
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($mpNewsMesssageContent)
		{
			Utils::checkNotEmptyStr($mpNewsMesssageContent->msgtype, 'msgtype');

			if ($mpNewsMesssageContent->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			$size = count($mpNewsMesssageContent->articles);
			if ($size < 1 || $size > 8) {
				throw new \QyApiError("1~8 articles should be given");
			}

			foreach ($mpNewsMesssageContent->articles as $item) {
				MpNewsArticle::CheckMessageSendArgs($item);
			}
		}

		/**
		 * @param MpNewsMessageContent $mpNewsMesssageContent
		 * @param                      $arr
		 */
		public static function MessageContent2Array ($mpNewsMesssageContent, &$arr)
		{
			Utils::setIfNotNull($mpNewsMesssageContent->msgtype, "msgtype", $arr);

			$articleList = [];
			foreach ($mpNewsMesssageContent->articles as $item) {
				$articleList[] = MpNewsArticle::Article2Array($item);
			}

			$arr[$mpNewsMesssageContent->msgtype]["articles"] = $articleList;
		}
	}