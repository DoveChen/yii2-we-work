<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/13
	 * Time: 11:50
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class TextMesssageContent
	 *
	 * @property string $msgtype 消息类型，此时固定为：text
	 * @property string $content 消息内容，最长不超过2048个字节，超过将截断（支持id转译）
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class TextMesssageContent
	{
		const MSG_TYPE = 'text';

		/**
		 * @param array $arr
		 *
		 * @return ImageMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$text = new TextMesssageContent();

			$text->msgtype = Utils::arrayGet($arr, 'msgtype');
			$text->content = Utils::arrayGet($arr, 'content');

			return $text;
		}

		/**
		 * @param TextMesssageContent $content
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($content)
		{
			Utils::checkNotEmptyStr($content->msgtype, 'msgtype');

			if ($content->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			Utils::checkNotEmptyStr($content->content, 'content');
		}

		/**
		 * @param TextMesssageContent $content
		 * @param                     $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$arr[$content->msgtype]['content'] = $content->content;
		}
	}