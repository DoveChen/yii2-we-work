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
	 * Class VideoMesssageContent
	 *
	 * @property string $msgtype     消息类型，此时固定为：video
	 * @property string $media_id    视频媒体文件id，可以调用上传临时素材接口获取
	 * @property string $title       视频消息的标题，不超过128个字节，超过会自动截断
	 * @property string $description 视频消息的描述，不超过512个字节，超过会自动截断
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class VideoMesssageContent
	{
		const MSG_TYPE = 'video';

		/**
		 * @param array $arr
		 *
		 * @return VideoMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$video = new VideoMesssageContent();

			$video->media_id    = Utils::arrayGet($arr, 'media_id');
			$video->title       = Utils::arrayGet($arr, 'title');
			$video->description = Utils::arrayGet($arr, 'description');

			return $video;
		}

		/**
		 * @param VideoMesssageContent $content
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

			Utils::checkNotEmptyStr($content->media_id, 'title');
		}

		/**
		 * @param VideoMesssageContent $content
		 * @param                      $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$args = [];
			Utils::setIfNotNull($content->media_id, "media_id", $args);
			Utils::setIfNotNull($content->title, "title", $args);
			Utils::setIfNotNull($content->description, "description", $args);

			Utils::setIfNotNull($args, $content->msgtype, $arr);
		}
	}