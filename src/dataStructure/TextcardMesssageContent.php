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
	 * Class TextcardMesssageContent
	 *
	 * @property string $msgtype     消息类型，此时固定为：textcard
	 * @property string $title       标题，不超过128个字节，超过会自动截断（支持id转译）
	 * @property string $description 描述，不超过512个字节，超过会自动截断（支持id转译）
	 * @property string $url         点击后跳转的链接。
	 * @property string $btntxt      按钮文字。 默认为“详情”， 不超过4个文字，超过自动截断。
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class TextcardMesssageContent
	{
		const MSG_TYPE = 'textcard';

		/**
		 * @param array $arr
		 *
		 * @return TextcardMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$textcard = new TextcardMesssageContent();

			$textcard->msgtype     = static::MSG_TYPE;
			$textcard->title       = Utils::arrayGet($arr, 'title');
			$textcard->description = Utils::arrayGet($arr, 'description');
			$textcard->url         = Utils::arrayGet($arr, 'url');
			$textcard->btntxt      = Utils::arrayGet($arr, 'btntxt');

			return $textcard;
		}

		/**
		 * @param TextcardMesssageContent $textcardMesssageContent
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($textcardMesssageContent)
		{
			Utils::checkNotEmptyStr($textcardMesssageContent->msgtype, 'msgtype');

			if ($textcardMesssageContent->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			Utils::checkNotEmptyStr($textcardMesssageContent->title, 'title');
			Utils::checkNotEmptyStr($textcardMesssageContent->description, 'description');
			Utils::checkNotEmptyStr($textcardMesssageContent->url, 'url');
		}

		/**
		 * @param TextcardMesssageContent $content
		 * @param                         $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$args = [];
			Utils::setIfNotNull($content->title, "title", $args);
			Utils::setIfNotNull($content->description, "description", $args);
			Utils::setIfNotNull($content->url, "url", $args);
			Utils::setIfNotNull($content->btntxt, "btntxt", $args);

			Utils::setIfNotNull($args, $content->msgtype, $arr);
		}
	}