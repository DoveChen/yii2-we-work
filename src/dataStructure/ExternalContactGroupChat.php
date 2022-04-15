<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactGroupChat
	 *
	 * @property string $chat_id        客户群ID
	 * @property string $name           群名
	 * @property string $owner          群主ID
	 * @property string $create_time    群的创建时间
	 * @property string $notice         群公告
	 * @property array  $member_list    群成员列表
	 * @property array  $admin_list     群管理员列表
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactGroupChat
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactGroupChat
		 */
		public static function parseFromArray ($arr)
		{
			$groupChat = new ExternalContactGroupChat();

			$groupChat->chat_id     = Utils::arrayGet($arr, 'chat_id');
			$groupChat->name        = Utils::arrayGet($arr, 'name');
			$groupChat->owner       = Utils::arrayGet($arr, 'owner');
			$groupChat->create_time = Utils::arrayGet($arr, 'create_time');
			$groupChat->notice      = Utils::arrayGet($arr, 'notice');

			$groupChat->member_list = [];
			$memberList             = Utils::arrayGet($arr, 'member_list');
			if (is_array($memberList)) {
				foreach ($memberList as $item) {
					array_push($groupChat->member_list, ExternalContactGroupChatMemberList::parseFromArray($item));
				}
			}
			$groupChat->admin_list = [];
			$adminList             = Utils::arrayGet($arr, 'admin_list');
			if (is_array($adminList)) {
				foreach ($adminList as $item) {
					array_push($groupChat->admin_list, ExternalContactGroupChatAdminList::parseFromArray($item));
				}
			}

			return $groupChat;
		}

		/**
		 * @param array $args
		 *
		 * @throws \ParameterError
		 */
		public static function checkGroupChatStatisticArgs (&$args)
		{
			if (empty($args['day_begin_time'])) {
				throw new \ParameterError('input error paramter.');
			}

			// 开始时间，填当天开始的0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前60天
			$startTimeDateObject = date_create(date('Y-m-d 00:00:00', time()));
			date_sub($startTimeDateObject, date_interval_create_from_date_string("1 days"));
			$maxStartTime = $startTimeDateObject->getTimestamp();
			date_sub($startTimeDateObject, date_interval_create_from_date_string("59 days"));
			$minStartTime = $startTimeDateObject->getTimestamp();

			$startTimeDate = date('Y-m-d 00:00:00', $args['day_begin_time']);
			$newStartTime  = strtotime($startTimeDate);
			if ($newStartTime < $minStartTime || $newStartTime > $maxStartTime) {
				throw new \ParameterError('invalid day_begin_time.');
			}

			if ($args['day_begin_time'] != $newStartTime) {
				$args['day_begin_time'] = $newStartTime;
			}
		}
	}