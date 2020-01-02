<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class UserDetailByUserTicket
	 * @property string $corpid     用户所属企业的corpid
	 * @property string $userid     成员UserID
	 * @property string $name       成员姓名，此字段从2019年12月30日起，对新创建第三方应用不再返回，2020年6月30日起，对所有历史第三方应用不再返回，第三方页面需要通过通讯录展示组件来展示名字
	 * @property string $gender     性别。0表示未定义，1表示男性，2表示女性
	 * @property string $avatar     头像url。仅在用户同意snsapi_privateinfo授权时返回
	 * @property string $qr_code    员工个人二维码（扫描可添加为外部联系人），仅在用户同意snsapi_privateinfo授权时返回
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class UserDetailByUserTicket
	{
		/**
		 * @param array $arr
		 *
		 * @return UserDetailByUserTicket
		 */
		public static function parseFromArray ($arr)
		{
			$userDetail = new UserDetailByUserTicket();

			$userDetail->corpid  = Utils::arrayGet($arr, 'corpid');
			$userDetail->userid  = Utils::arrayGet($arr, 'userid');
			$userDetail->name    = Utils::arrayGet($arr, 'name');
			$userDetail->gender  = Utils::arrayGet($arr, 'gender');
			$userDetail->avatar  = Utils::arrayGet($arr, 'avatar');
			$userDetail->qr_code = Utils::arrayGet($arr, 'qr_code');

			return $userDetail;
		}
	}