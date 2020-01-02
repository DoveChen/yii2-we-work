<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactMsgTemplateLink
	 *
	 * @property string $title     图文消息标题
	 * @property string $picurl    图文消息封面的url
	 * @property string $desc      图文消息的描述，最多512个字节
	 * @property string $url       图文消息的链接
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactMsgTemplateLink
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactMsgTemplateLink
		 */
		public static function parseFromArray ($arr)
		{
			$linkTemplate = new ExternalContactMsgTemplateLink();

			$linkTemplate->title  = Utils::arrayGet($arr, 'title');
			$linkTemplate->picurl = Utils::arrayGet($arr, 'picurl');
			$linkTemplate->desc   = Utils::arrayGet($arr, 'desc');
			$linkTemplate->url    = Utils::arrayGet($arr, 'url');

			return $linkTemplate;
		}
	}