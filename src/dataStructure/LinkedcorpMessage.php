<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/13
	 * Time: 13:08
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class LinkedcorpMessage
	 *
	 * @property array                                                                                                                                                                                                                                                 $touser                   指定接收消息的成员，成员ID列表（多个接收者用‘|’分隔，最多支持1000个）。特殊情况：指定为”@all”，则向该企业应用的全部成员发送
	 * @property array                                                                                                                                                                                                                                                 $toparty                  指定接收消息的部门，部门ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为”@all”时忽略本参数
	 * @property array                                                                                                                                                                                                                                                 $totag                    指定接收消息的标签，标签ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为”@all”时忽略本参数
	 * @property int                                                                                                                                                                                                                                                   $toall                    1表示发送给应用可见范围内的所有人（包括互联企业的成员），默认为0
	 * @property int                                                                                                                                                                                                                                                   $agentid                  企业应用的id，整型。企业内部开发，可在应用的设置页面查看；第三方服务商，可通过接口 获取企业授权信息 获取该参数值
	 * @property int                                                                                                                                                                                                                                                   $safe                     表示是否是保密消息，0表示否，1表示是，默认0
	 * @property TextMesssageContent|ImageMesssageContent|VoiceMesssageContent|VideoMesssageContent|FileMesssageContent|TextcardMesssageContent|NewsMessageContent|MpNewsMessageContent|MarkdownMessageContent|MiniprogramNoticeMessageContent|TaskcardMesssageContent $messageContent           消息体
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class LinkedcorpMessage
	{
		/**
		 * @param array $arr
		 *
		 * @return LinkedcorpMessage
		 */
		public static function pareFromArray ($arr)
		{
			$message = new LinkedcorpMessage();

			$message->touser         = Utils::arrayGet($arr, 'touser');
			$message->toparty        = Utils::arrayGet($arr, 'toparty');
			$message->totag          = Utils::arrayGet($arr, 'totag');
			$message->toall          = Utils::arrayGet($arr, 'toall');
			$message->agentid        = Utils::arrayGet($arr, 'agentid');
			$message->safe           = Utils::arrayGet($arr, 'safe');
			$message->messageContent = Utils::arrayGet($arr, 'messageContent');

			return $message;
		}

		/**
		 * @param LinkedcorpMessage $args
		 *
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			if (is_array($args->touser) && count($args->touser) > 1000) {
				throw new \QyApiError("touser should be no more than 1000");
			}
			if (is_array($args->toparty) && count($args->toparty) > 100) {
				throw new \QyApiError("toparty should be no more than 100");
			}
			if (is_array($args->totag) && count($args->totag) > 100) {
				throw new \QyApiError("toparty should be no more than 100");
			}

			if (is_null($args->messageContent)) {
				throw new \QyApiError("messageContent is empty");
			}

			$messageContentClass = get_class($args->messageContent);
			$messageContentClass::CheckMessageSendArgs($args->messageContent);
		}

		/**
		 * @param LinkedcorpMessage $message
		 *
		 * @return array
		 */
		public static function Message2Array ($message)
		{
			$args          = [];
			$touser_string = implode('|', $message->touser);
			Utils::setIfNotNull($touser_string, "touser", $args);

			$toparty_string = implode('|', $message->toparty);
			Utils::setIfNotNull($toparty_string, "toparty", $args);

			$totag_string = implode('|', $message->totag);
			Utils::setIfNotNull($totag_string, "totag", $args);

			Utils::setIfNotNull($message->toall, "toall", $args);
			Utils::setIfNotNull($message->agentid, "agentid", $args);
			Utils::setIfNotNull($message->safe, "safe", $args);

			$messageContentClass = get_class($message->messageContent);
			$messageContentClass::MessageContent2Array($message->messageContent, $args);

			return $args;
		}
	}