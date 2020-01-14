<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/11
	 * Time: 15:31
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class NewsMessageContent
	 *
	 * @property string $msgtype   消息类型，此时固定为：mpnews
	 * @property array  $articles  图文消息，一个图文消息支持1到8条图文
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class NewsMessageContent
	{
		const MSG_TYPE = 'news';

		/**
		 * @param $arr
		 *
		 * @return NewsMessageContent
		 */
		public static function parseFromArray ($arr)
		{
			$newsMesssageContent = new NewsMessageContent();

			$newsMesssageContent->msgtype  = static::MSG_TYPE;
			$newsMesssageContent->articles = Utils::arrayGet($arr, 'articles');

			return $newsMesssageContent;
		}

		/**
		 * @param NewsMessageContent $newsMesssageContent
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($newsMesssageContent)
		{
			Utils::checkNotEmptyStr($newsMesssageContent->msgtype, 'msgtype');

			if ($newsMesssageContent->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			$size = count($newsMesssageContent->articles);
			if ($size < 1 || $size > 8) {
				throw new \QyApiError("1~8 articles should be given");
			}

			foreach ($newsMesssageContent->articles as $item) {
				MpNewsArticle::CheckMessageSendArgs($item);
			}
		}

		/**
		 * @param NewsMessageContent $newsMesssageContent
		 * @param                    $arr
		 */
		public static function MessageContent2Array ($newsMesssageContent, &$arr)
		{
			Utils::setIfNotNull($newsMesssageContent->msgtype, "msgtype", $arr);

			$articleList = [];
			foreach ($newsMesssageContent->articles as $item) {
				$articleList[] = MpNewsArticle::Article2Array($item);
			}

			$arr[$newsMesssageContent->msgtype]["articles"] = $articleList;
		}
	}