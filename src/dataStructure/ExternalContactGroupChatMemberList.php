<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactGroupChatMemberList
	 *
	 * @property string $userid           群成员id
	 * @property int    $type             成员类型。1 - 企业成员 2 - 外部联系人
	 * @property string $unionid          外部联系人在微信开放平台的唯一身份标识（微信unionid），通过此字段企业可将外部联系人与公众号/小程序用户关联起来。仅当群成员类型是微信用户（包括企业成员未添加好友），且企业绑定了微信开发者ID有此字段（查看绑定方法）。第三方不可获取，上游企业不可获取下游企业客户的unionid字段
	 * @property string $join_time        入群时间
	 * @property int    $join_scene       入群方式。1 - 由成员邀请入群（直接邀请入群）2 - 由成员邀请入群（通过邀请链接入群）3 - 通过扫描群二维码入群
	 * @property array  $invitor          邀请者。目前仅当是由本企业内部成员邀请入群时会返回该值
	 * @property string $group_nickname   在群里的昵称
	 * @property string $name             名字。仅当 need_name = 1 时返回 如果是微信用户，则返回其在微信中设置的名字 如果是企业微信联系人，则返回其设置对外展示的别名或实名
	 * @property string $state            入群渠道标识
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
			$memberList->unionid    = Utils::arrayGet($arr, 'unionid');
			$memberList->join_time  = Utils::arrayGet($arr, 'join_time');
			$memberList->join_scene = Utils::arrayGet($arr, 'join_scene');
			$memberList->state      = Utils::arrayGet($arr, 'state');

			$memberList->invitor = [];
			$invitor             = Utils::arrayGet($arr, 'invitor');
			if (is_array($invitor)) {
				$memberList->invitor = $invitor;
			}

			$memberList->group_nickname = Utils::arrayGet($arr, 'group_nickname');
			$memberList->name           = Utils::arrayGet($arr, 'name');

			return $memberList;
		}
	}