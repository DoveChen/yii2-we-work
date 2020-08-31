<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactRemark
	 *
	 * @property string $userid             企业成员的userid
	 * @property string $external_userid    外部联系人userid
	 * @property string $remark             此用户对外部联系人的备注
	 * @property string $description        此用户对外部联系人的描述
	 * @property string $remark_company     此用户对外部联系人备注的所属公司名称
	 * @property array  $remark_mobiles     此用户对外部联系人备注的手机号
	 * @property string $remark_pic_mediaid 备注图片的mediaid，
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactRemark
	{
		/**
		 * @param $arr
		 *
		 * @return ExternalContactRemark
		 *
		 */
		public static function parseFromArray ($arr)
		{
			$contactRemark = new ExternalContactRemark();
			$userid        = Utils::arrayGet($arr, 'userid');
			if (!is_null($userid)) {
				$contactRemark->userid = $userid;
			}
			$externalUserId = Utils::arrayGet($arr, 'external_userid');
			if (!is_null($externalUserId)) {
				$contactRemark->external_userid = $externalUserId;
			}
			$remark = Utils::arrayGet($arr, 'remark');
			if (!is_null($remark)) {
				$contactRemark->remark = $remark;
			}
			$description = Utils::arrayGet($arr, 'description');
			if (!is_null($description)) {
				$contactRemark->description = $description;
			}
			$remarkCompany = Utils::arrayGet($arr, 'remark_company');
			if (!is_null($remarkCompany)) {
				$contactRemark->remark_company = $remarkCompany;
			}
			$remarkMobiles = Utils::arrayGet($arr, 'remark_mobiles');
			if (!is_null($remarkMobiles)) {
				$contactRemark->remark_mobiles = $remarkMobiles;
			}
			$mediaId = Utils::arrayGet($arr, 'remark_pic_mediaid');
			if (!is_null($mediaId)) {
				$contactRemark->remark_pic_mediaid = $mediaId;
			}

			return $contactRemark;
		}

		/**
		 * @param ExternalContactRemark $externalContactRemark
		 *
		 * @throws \ParameterError
		 */
		public static function CheckExternalContactRmarkArgs ($externalContactRemark)
		{
			Utils::checkNotEmptyStr($externalContactRemark->userid, 'userid');
			Utils::checkNotEmptyStr($externalContactRemark->external_userid, 'external userid');

//			if (!Utils::notEmptyStr($externalContactRemark->remark) && !Utils::notEmptyStr($externalContactRemark->description) && !Utils::notEmptyStr($externalContactRemark->remark_company) && !Utils::notEmptyArray($externalContactRemark->remark_mobiles) && !Utils::notEmptyStr($externalContactRemark->remark_pic_mediaid)) {
//				throw new \ParameterError('input error parameter.');
//			}
		}
	}