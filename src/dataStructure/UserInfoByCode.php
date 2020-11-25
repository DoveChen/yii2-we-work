<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class UserInfoByCode
	 *
	 * @property string $CorpId             用户所属企业的corpid
	 * @property string $UserId             用户在企业内的UserID，如果该企业与第三方应用有授权关系时，返回明文UserId，否则返回密文UserId
	 * @property string $external_userid    外部联系人id，当且仅当用户是企业的客户，且跟进人在应用的可见范围内时返回。如果是第三方应用调用，针对同一个客户，同一个服务商不同应用获取到的id相同
	 * @property string $OpenId             非企业成员的标识，对当前服务商唯一
	 * @property string $DeviceId           手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
	 * @property string $user_ticket        成员票据，最大为512字节。  scope为snsapi_userinfo或snsapi_privateinfo，且用户在应用可见范围之内时返回此参数。
	 * @property string $expires_in         user_ticket的有效时间（秒），随user_ticket一起返回
	 * @property string $open_userid        全局唯一。对于同一个服务商，不同应用获取到企业内同一个成员的open_userid是相同的，最多64个字节。仅第三方应用可获取
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

			$userInfo->CorpId          = Utils::arrayGet($arr, 'CorpId');
			$userInfo->UserId          = Utils::arrayGet($arr, 'UserId');
			$userInfo->external_userid = Utils::arrayGet($arr, 'external_userid');
			$userInfo->OpenId          = Utils::arrayGet($arr, 'OpenId');
			$userInfo->DeviceId        = Utils::arrayGet($arr, 'DeviceId');
			$userInfo->user_ticket     = Utils::arrayGet($arr, 'user_ticket');
			$userInfo->expires_in      = Utils::arrayGet($arr, 'expires_in');
			$userInfo->open_userid     = Utils::arrayGet($arr, 'open_userid');

			return $userInfo;
		}
	}