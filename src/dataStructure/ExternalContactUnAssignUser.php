<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactUnAssignUser
	 *
	 * @property string $handover_userid    离职成员的userid
	 * @property string $external_userid    外部联系人userid
	 * @property string $dimission_time     成员离职时间
	 * @property string $takeover_userid    接替成员的userid
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactUnAssignUser
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactUnAssignUser
		 */
		public static function parseFromArray ($arr)
		{
			$unAssignUser = new ExternalContactUnAssignUser();

			$unAssignUser->handover_userid = Utils::arrayGet($arr, 'handover_userid');
			$unAssignUser->external_userid = Utils::arrayGet($arr, 'external_userid');
			$unAssignUser->dimission_time  = Utils::arrayGet($arr, 'dimission_time');

			return $unAssignUser;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function arrayToUnAssignUserInfo ($arr)
		{
			$unAssignUserInfo = [];

			$unAssignUser = Utils::arrayGet($arr, 'info');

			if (!is_null($unAssignUser)) {
				foreach ($unAssignUser as $item) {
					array_push($unAssignUserInfo, ExternalContactUnAssignUser::parseFromArray($item));
				}
			}

			return $unAssignUserInfo;
		}
	}