<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContact
	 *
	 * @property string $external_userid     外部联系人的userid
	 * @property string $name                外部联系人的姓名或别名
	 * @property string $avatar              外部联系人头像，第三方不可获取
	 * @property int    $type                外部联系人的类型，1表示该外部联系人是微信用户，2表示该外部联系人是企业微信用户
	 * @property int    $gender              外部联系人性别 0-未知 1-男性 2-女性
	 * @property string $unionid             外部联系人在微信开放平台的唯一身份标识（微信unionid），通过此字段企业可将外部联系人与公众号/小程序用户关联起来。仅当联系人类型是微信用户，且企业绑定了微信开发者ID有此字段。查看绑定方法
	 * @property string $position            外部联系人的职位，如果外部企业或用户选择隐藏职位，则不返回，仅当联系人类型是企业微信用户时有此字段
	 * @property string $corp_name           外部联系人所在企业的简称，仅当联系人类型是企业微信用户时有此字段
	 * @property string $corp_full_name      外部联系人所在企业的主体名称，仅当联系人类型是企业微信用户时有此字段
	 * @property array  $external_profile    外部联系人的自定义展示信息，可以有多个字段和多种类型，包括文本，网页和小程序，仅当联系人类型是企业微信用户时有此字段，字段详情见对外属性；
	 * @property array  $follow_user         添加了此外部联系人的企业成员列表
	 * @property array  $contact_way         企业已配置的「联系我」方式
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContact
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContact
		 */
		public static function wayParseFromArray ($arr)
		{
			$externalContact = new ExternalContact();

			$externalContactWay = Utils::arrayGet($arr, 'contact_way');

			if (!is_null($externalContactWay)) {
				$externalContact->contact_way = ExternalContactWay::parseFromArray($externalContactWay);
			}

			return $externalContact;
		}

		/**
		 * @param array $arr
		 *
		 * @return ExternalContact
		 */
		public static function parseFromArray ($arr)
		{
			$externalContact = new ExternalContact();

			$externalContact->external_userid = Utils::arrayGet($arr, 'external_userid');
			$externalContact->name            = Utils::arrayGet($arr, 'name');
			$externalContact->avatar          = Utils::arrayGet($arr, 'avatar');
			$externalContact->type            = Utils::arrayGet($arr, 'type');
			$externalContact->gender          = Utils::arrayGet($arr, 'gender');
			$externalContact->unionid         = Utils::arrayGet($arr, 'unionid');
			$externalContact->position        = Utils::arrayGet($arr, 'position');
			$externalContact->corp_name       = Utils::arrayGet($arr, 'corp_name');
			$externalContact->corp_full_name  = Utils::arrayGet($arr, 'corp_full_name');

			$externalProfile = Utils::arrayGet($arr, 'external_profile');
			if (Utils::notEmptyArray($externalProfile)) {
				$externalContact->external_profile = ExternalProfile::parseFromArray($externalProfile);
			}

			$followUser = Utils::arrayGet($arr, 'follow_user');
			if (Utils::notEmptyArray($followUser)) {
				$externalContact->follow_user = [];
				foreach ($followUser as $item) {
					array_push($externalContact->follow_user, ExternalContactFollowUser::parseFromArray($item));
				}
			}

			return $externalContact;
		}
	}