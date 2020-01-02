<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactGroupChatMemberList
	 *
	 * @property string $userid       群成员id
	 * @property int    $type         成员类型。1 - 企业成员 2 - 外部联系人
	 * @property string $join_time    入群时间
	 * @property int    $join_scene   入群方式。1 - 由成员邀请入群（直接邀请入群）2 - 由成员邀请入群（通过邀请链接入群）3 - 通过扫描群二维码入群
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactGroupChatMemberList
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactGroupChatMemberList
		 */
		public static function parseFromArray ($arr)
		{
			$memberList = new ExternalContactGroupChatMemberList();

			$memberList->userid     = Utils::arrayGet($arr, 'userid');
			$memberList->type       = Utils::arrayGet($arr, 'type');
			$memberList->join_time  = Utils::arrayGet($arr, 'join_time');
			$memberList->join_scene = Utils::arrayGet($arr, 'join_scene');

			return $memberList;
		}
	}