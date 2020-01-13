<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/13
	 * Time: 11:36
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class MarkdownMessageContent
	 *
	 * @property string $msgtype      消息类型，此时固定为：markdown
	 * @property string $content      markdown内容，最长不超过2048个字节，必须是utf8编码
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MarkdownMessageContent
	{
		const MSG_TYPE = 'markdown';

		/**
		 * @param $arr
		 *
		 * @return MarkdownMessageContent
		 */
		public static function parseFromArray ($arr)
		{
			$markdownMessageContent = new MarkdownMessageContent();

			$markdownMessageContent->content = Utils::arrayGet($arr, 'content');

			return $markdownMessageContent;
		}

		/**
		 * @param MarkdownMessageContent $mpNewsMesssageContent
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
		}

		/**
		 * @param MarkdownMessageContent $markdownMessageContent
		 * @param                        $arr
		 */
		public static function MessageContent2Array ($markdownMessageContent, &$arr)
		{
			Utils::setIfNotNull($markdownMessageContent->msgtype, "msgtype", $arr);

			$arr[$markdownMessageContent->msgtype]["content"] = $markdownMessageContent->content;
		}
	}