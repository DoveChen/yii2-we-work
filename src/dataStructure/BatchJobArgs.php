<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class BatchJobArgs
	 *
	 * @property string        media_id    上传的csv文件的media_id
	 * @property boolean       to_invite   是否邀请新建的成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
	 * @property BatchCallback callback    回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class BatchJobArgs
	{
		/**
		 * @param array $arr
		 *
		 * @return BatchJobArgs
		 */
		public static function parseFromArray ($arr)
		{
			$jobArgs = new BatchJobArgs();

			$jobArgs->media_id  = Utils::arrayGet($arr, "media_id");
			$jobArgs->to_invite = Utils::arrayGet($arr, "to_invite");
			$jobArgs->callback  = BatchCallback::parseFromArray(Utils::arrayGet($arr, 'callback'));

			return $jobArgs;
		}
	}