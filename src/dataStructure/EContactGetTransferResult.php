<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class EContactGetTransferResult
	 *
	 * @property string   $external_userid          客户的userid，注意不是企业成员的帐号
	 * @property string   $handover_userid          转移成员的userid
	 * @property string   $takeover_userid          接替成员的userid
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class EContactGetTransferResult
	{
		/**
		 * @param array $arr
		 *
		 * @return EContactGetTransferResult
		 */
		public static function parseFromArray ($arr)
		{
			$behaviorData = new EContactGetTransferResult();

			$behaviorData->external_userid = Utils::arrayGet($arr, 'external_userid');
			$behaviorData->handover_userid = Utils::arrayGet($arr, 'handover_userid');
			$behaviorData->takeover_userid = Utils::arrayGet($arr, 'takeover_userid');

			return $behaviorData;
		}
	}