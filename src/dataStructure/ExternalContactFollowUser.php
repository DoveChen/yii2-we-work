<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactFollowUser
	 *
	 * @property string $userid             添加了此外部联系人的企业成员userid
	 * @property string $remark             该成员对此外部联系人的备注
	 * @property string $description        该成员对此外部联系人的描述
	 * @property string $createtime         该成员添加此外部联系人的时间
	 * @property array  $tags               标签信息
	 * @property string $remark_corp_name   该成员对此客户备注的企业名称
	 * @property array  $remark_mobiles     该成员对此客户备注的手机号码，第三方不可获取
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactFollowUser
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactFollowUser
		 */
		public static function parseFromArray ($arr)
		{
			$externalContactFollowUser = new ExternalContactFollowUser();

			$externalContactFollowUser->userid      = Utils::arrayGet($arr, 'userid');
			$externalContactFollowUser->remark      = Utils::arrayGet($arr, 'remark');
			$externalContactFollowUser->description = Utils::arrayGet($arr, 'description');
			$externalContactFollowUser->createtime  = Utils::arrayGet($arr, 'createtime');

			$userTags = Utils::arrayGet($arr, 'tags');
			if (Utils::notEmptyArray($userTags)) {
				$externalContactFollowUser->tags = [];

				foreach ($userTags as $item) {
					array_push($externalContactFollowUser->tags, ExternalContactFollowUserTag::parseFromArray($item));
				}
			}

			$externalContactFollowUser->remark_corp_name = Utils::arrayGet($arr, 'remark_corp_name');
			$externalContactFollowUser->remark_mobiles   = Utils::arrayGet($arr, 'remark_mobiles');

			return $externalContactFollowUser;
		}
	}