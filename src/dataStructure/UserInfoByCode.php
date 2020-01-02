<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class UserInfoByCode
	 *
	 * @property string $CorpId         用户所属企业的corpid
	 * @property string $UserId         用户在企业内的UserID，如果该企业与第三方应用有授权关系时，返回明文UserId，否则返回密文UserId
	 * @property string $OpenId         非企业成员的标识，对当前服务商唯一
	 * @property string $DeviceId       手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
	 * @property string $user_ticket    成员票据，最大为512字节。  scope为snsapi_userinfo或snsapi_privateinfo，且用户在应用可见范围之内时返回此参数。
	 * @property string $expires_in     user_ticket的有效时间（秒），随user_ticket一起返回
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class UserInfoByCode
	{
		/**
		 * @param array $arr
		 *
		 * @return UserInfoByCode
		 */
		public static function parseFromArray ($arr)
		{
			$userInfo = new UserInfoByCode();

			$userInfo->CorpId      = Utils::arrayGet($arr, 'CorpId');
			$userInfo->UserId      = Utils::arrayGet($arr, 'UserId');
			$userInfo->OpenId      = Utils::arrayGet($arr, 'OpenId');
			$userInfo->DeviceId    = Utils::arrayGet($arr, 'DeviceId');
			$userInfo->user_ticket = Utils::arrayGet($arr, 'user_ticket');
			$userInfo->expires_in  = Utils::arrayGet($arr, 'expires_in');

			return $userInfo;
		}
	}