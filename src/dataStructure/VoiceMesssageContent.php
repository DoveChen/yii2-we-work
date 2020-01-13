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
	 * Class VoiceMesssageContent
	 *
	 * @property string $msgtype  消息类型，此时固定为：voice
	 * @property string $media_id 语音文件id，可以调用上传临时素材接口获取
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class VoiceMesssageContent
	{
		const MSG_TYPE = 'voice';

		/**
		 * @param array $arr
		 *
		 * @return VoiceMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$voice = new VoiceMesssageContent();

			$voice->media_id = Utils::arrayGet($arr, 'media_id');

			return $voice;
		}

		/**
		 * @param VoiceMesssageContent $content
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
		 * @param VoiceMesssageContent $content
		 * @param                      $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$arr[$content->msgtype]['media_id'] = $content->media_id;
		}
	}