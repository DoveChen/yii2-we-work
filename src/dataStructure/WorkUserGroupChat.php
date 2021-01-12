<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactGroupChat
	 *
	 * @property string $roomid              客户群ID
	 * @property string $roomname            群名
	 * @property string $creator             群主ID
	 * @property string $room_create_time    群的创建时间
	 * @property string $notice              群公告
	 * @property array  $members             群成员列表
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class WorkUserGroupChat
	{
		/**
		 * @param array $arr
		 *
		 * @return WorkUserGroupChat
		 */
		public static function parseFromArray ($arr)
		{
			$groupChat = new WorkUserGroupChat();

			$groupChat->roomid           = Utils::arrayGet($arr, 'roomid');
			$groupChat->roomname         = Utils::arrayGet($arr, 'roomname');
			$groupChat->creator          = Utils::arrayGet($arr, 'creator');
			$groupChat->room_create_time = Utils::arrayGet($arr, 'room_create_time');
			$groupChat->notice           = Utils::arrayGet($arr, 'notice');
			$memberList                  = Utils::arrayGet($arr, '$members');
			if (is_array($memberList)) {
				$groupChat->members = [];
				foreach ($memberList as $item) {
					array_push($groupChat->members, WorkUserGroupChatMembers::parseFromArray($item));
				}
			}

			return $groupChat;
		}
	}