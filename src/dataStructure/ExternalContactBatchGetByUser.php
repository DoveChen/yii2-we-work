<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactBatchGetByUser
	 *
	 * @property string  $userid             企业成员的userid，字符串类型
	 * @property string  $cursor             用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * @property integer $limit              返回的最大记录数，整型，最大值100，默认值50，超过最大值时取最大值
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactBatchGetByUser
	{
		/**
		 * @param $arr
		 *
		 * @return ExternalContactBatchGetByUser
		 */
		public static function parseFromArray ($arr)
		{
			$batchGetByUser         = new ExternalContactBatchGetByUser();
			$batchGetByUser->userid = Utils::arrayGet($arr, 'userid');

			$cursor = Utils::arrayGet($arr, 'cursor');
			if (!is_null($cursor)) {
				$batchGetByUser->cursor = $cursor;
			}

			$batchGetByUser->limit = Utils::arrayGet($arr, 'limit', 100);

			return $batchGetByUser;
		}

		/**
		 * @param ExternalContactBatchGetByUser $batchGetByUser
		 *
		 * @throws \ParameterError
		 */
		public static function CheckExternalContactBatchGetByUserArgs ($batchGetByUser)
		{
			Utils::checkNotEmptyStr($batchGetByUser->userid, 'userid');

			$limit = $batchGetByUser->limit;
			if ($limit <= 0 || $limit > 100) {
				throw new ParameterError("limit can not le 0 or gt 100");
			}
		}
	}