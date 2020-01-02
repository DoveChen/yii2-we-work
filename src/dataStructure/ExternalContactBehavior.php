<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactBehavior
	 *
	 * @property int   $stat_time                数据日期，为当日0点的时间戳
	 * @property int   $new_apply_cnt            发起申请数，成员通过「搜索手机号」、「扫一扫」、「从微信好友中添加」、「从群聊中添加」、「添加共享、分配给我的客户」、「添加单向、双向删除好友关系的好友」、「从新的联系人推荐中添加」等渠道主动向客户发起的好友申请数量。
	 * @property int   $new_contact_cnt          新增客户数，成员新添加的客户数量。
	 * @property int   $chat_cnt                 聊天总数， 成员有主动发送过消息的聊天数，包括单聊和群聊。
	 * @property int   $message_cnt              发送消息数，成员在单聊和群聊中发送的消息总数。
	 * @property float $reply_percentage         已回复聊天占比，客户主动发起聊天后，成员在一个自然日内有回复过消息的聊天数/客户主动发起的聊天数比例，不包括群聊，仅在确有回复时返回。
	 * @property int   $avg_reply_time           平均首次回复时长，单位为分钟，即客户主动发起聊天后，成员在一个自然日内首次回复的时长间隔为首次回复时长，所有聊天的首次回复总时长/已回复的聊天总数即为平均首次回复时长，不包括群聊，仅在确有回复时返回。
	 * @property int   $negative_feedback_cnt    删除/拉黑成员的客户数，即将成员删除或加入黑名单的客户数。
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactBehavior
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactBehavior
		 */
		public static function parseFromArray ($arr)
		{
			$behaviorData = new ExternalContactBehavior();

			$behaviorData->stat_time             = Utils::arrayGet($arr, 'stat_time');
			$behaviorData->chat_cnt              = Utils::arrayGet($arr, 'chat_cnt');
			$behaviorData->message_cnt           = Utils::arrayGet($arr, 'message_cnt');
			$behaviorData->reply_percentage      = Utils::arrayGet($arr, 'reply_percentage');
			$behaviorData->avg_reply_time        = Utils::arrayGet($arr, 'avg_reply_time');
			$behaviorData->negative_feedback_cnt = Utils::arrayGet($arr, 'negative_feedback_cnt');
			$behaviorData->new_apply_cnt         = Utils::arrayGet($arr, 'new_apply_cnt');
			$behaviorData->new_contact_cnt       = Utils::arrayGet($arr, 'new_contact_cnt');

			return $behaviorData;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function arrayToBehaviorData ($arr)
		{
			$behaviorData = [];

			$behavior = Utils::arrayGet($arr, 'behavior_data');
			if (!is_null($behavior)) {
				foreach ($behavior as $item) {
					array_push($behaviorData, ExternalContactBehavior::parseFromArray($item));
				}
			}

			return $behaviorData;
		}

		/**
		 * @param array $args
		 *
		 * @throws \ParameterError
		 */
		public static function checkBehaviorGetArgs (&$args)
		{
			if (!Utils::notEmptyArray($args['userid']) && !Utils::notEmptyArray($args['userid'])) {
				throw new \ParameterError('input error paramter.');
			}

			if (empty($args['start_time']) || empty($args['end_time'])) {
				throw new \ParameterError('input error paramter.');
			}

			/*
			 * 查询的时间范围为[start_time,end_time]，即前后均为闭区间，支持的最大查询跨度为30天；
			 * 用户最多可获取最近60天内的数据；
			 * 当传入的时间不为0点时间戳时，会向下取整，如传入1554296400(Wed Apr 3 21:00:00 CST 2019)会被自动转换为1554220800（Wed Apr 3 00:00:00 CST 2019）;
			 */
			$startTimeDateObject = date_create(date('Y-m-d 00:00:00', time()));
			date_sub($startTimeDateObject, date_interval_create_from_date_string("60 days"));
			$minStartTime = $startTimeDateObject->getTimestamp();

			$startTimeDate = date('Y-m-d 00:00:00', $args['start_time']);
			$newStartTime  = strtotime($startTimeDate);
			if ($newStartTime < $minStartTime) {
				throw new \ParameterError('invalid start_time date.');
			}

			$endTimeDate = date('Y-m-d 00:00:00', $args['end_time']);
			$newEndTime  = strtotime($endTimeDate);

			if ($args['start_time'] != $newStartTime) {
				$args['start_time'] = $newStartTime;
			}
			if ($args['end_time'] != $newEndTime) {
				$args['end_time'] = $newEndTime;
			}

			if ($args['end_time'] <= $args['start_time']) {
				throw new \ParameterError('invalid time date.');
			}

			if ($args['end_time'] - $args['start_time'] > 30 * 24 * 60 * 60) {
				throw new \ParameterError('invalid time ranger.');
			}
		}
	}