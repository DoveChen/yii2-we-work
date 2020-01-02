<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactMsgTemplateText
	 *
	 * @property string $contect 消息文本内容，最多4000个字节
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactMsgTemplateText
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactMsgTemplateText
		 */
		public static function parseFromArray ($arr)
		{
			$textTemplate = new ExternalContactMsgTemplateText();

			$textTemplate->contect = Utils::arrayGet($arr, 'content');

			return $textTemplate;
		}
	}