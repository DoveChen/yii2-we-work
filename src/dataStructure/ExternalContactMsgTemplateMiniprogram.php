<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactMsgTemplateMiniprogram
	 *
	 * @property string $title          小程序消息标题，最多64个字节
	 * @property string $pic_media_id   小程序消息封面的mediaid，封面图建议尺寸为520*416
	 * @property string $appid          小程序appid，必须是关联到企业的小程序应用
	 * @property string $page           小程序page路径
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactMsgTemplateMiniprogram
	{
		public static function parseFromArray ($arr)
		{
			$miniTemplate = new ExternalContactMsgTemplateMiniprogram();

			$miniTemplate->title        = Utils::arrayGet($arr, 'title');
			$miniTemplate->pic_media_id = Utils::arrayGet($arr, 'pic_media_id');
			$miniTemplate->appid        = Utils::arrayGet($arr, 'appid');
			$miniTemplate->page         = Utils::arrayGet($arr, 'page');

			return $miniTemplate;
		}
	}