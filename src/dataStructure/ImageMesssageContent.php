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
	 * Class ImageMesssageContent
	 *
	 * @property string $msgtype  消息类型，此时固定为：image
	 * @property string $media_id 图片媒体文件id，可以调用上传临时素材接口获取
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ImageMesssageContent
	{
		const MSG_TYPE = 'image';

		/**
		 * @param array $arr
		 *
		 * @return ImageMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$image = new VoiceMesssageContent();

			$image->media_id = Utils::arrayGet($arr, 'media_id');

			return $image;
		}

		/**
		 * @param ImageMesssageContent $content
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

			Utils::checkNotEmptyStr($content->media_id, 'media_id');
		}

		/**
		 * @param ImageMesssageContent $content
		 * @param                      $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$arr[$content->msgtype]['media_id'] = $content->media_id;
		}
	}