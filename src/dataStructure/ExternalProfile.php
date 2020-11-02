<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalProfile
	 *
	 * @property AttrItem $external_attr      属性列表，目前支持文本、网页、小程序三种类型
	 * @property string   $external_corp_name 企业对外简称，需从已认证的企业简称中选填。可在“我的企业”页中查看企业简称认证状态。
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalProfile
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalProfile
		 */
		public static function parseFromArray ($arr)
		{
			$externalProfile = new ExternalProfile();

			$externalCorpName = Utils::arrayGet($arr, "external_corp_name");
			if (!empty($externalCorpName)) {
				$externalProfile->external_corp_name = $externalCorpName;
			}

			$externalAttr = Utils::arrayGet($arr, "external_attr");
			if (!is_null($externalAttr) && !empty($externalAttr)) {
				$externalProfile->external_attr      = [];
				foreach ($externalAttr as $attr) {
					array_push($externalProfile->external_attr, AttrItem::parseFromArray($attr));
				}
			}

			return $externalProfile;
		}
	}