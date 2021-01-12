<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactGroupChatMemberList
	 *
	 * @property string $memberid       群成员id
	 * @property string $jointime       入群时间
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class WorkUserGroupChatMembers
	{
		/**
		 * @param array $arr
		 *
		 * @return WorkUserGroupChatMembers
		 */
		public static function parseFromArray ($arr)
		{
			$memberList = new WorkUserGroupChatMembers();

			$memberList->memberid = Utils::arrayGet($arr, 'memberid');
			$memberList->jointime = Utils::arrayGet($arr, 'jointime');

			return $memberList;
		}
	}