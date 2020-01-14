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
	 * Class FileMesssageContent
	 *
	 * @property string $msgtype  消息类型，此时固定为：file
	 * @property string $media_id 文件id，可以调用上传临时素材接口获取
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class FileMesssageContent
	{
		const MSG_TYPE = 'file';

		/**
		 * @param array $arr
		 *
		 * @return FileMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$file = new FileMesssageContent();

			$file->msgtype  = static::MSG_TYPE;
			$file->media_id = Utils::arrayGet($arr, 'media_id');

			return $file;
		}

		/**
		 * @param FileMesssageContent $content
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
		 * @param FileMesssageContent $content
		 * @param                     $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$arr[$content->msgtype]['media_id'] = $content->media_id;
		}
	}