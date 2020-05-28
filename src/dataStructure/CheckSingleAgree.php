<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/5/28
	 * Time: 10:07
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class CheckSingleAgree
	 *
	 * @property string userid          内部成员的userid
	 * @property string exteranalopenid 外部成员的externalopenid
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class CheckSingleAgree
	{
		/**
		 * @param $arr
		 *
		 * @return CheckSingleAgree
		 */
		public static function parseFromArray ($arr)
		{
			$checkSingleAgree = new self();

			$checkSingleAgree->userid          = Utils::arrayGet($arr, 'userid');
			$checkSingleAgree->exteranalopenid = Utils::arrayGet($arr, 'exteranalopenid');

			return $checkSingleAgree;
		}

		/**
		 * @param CheckSingleAgree $checkSingleAgree
		 *
		 * @return array
		 */
		public static function ToArray ($checkSingleAgree)
		{
			$args = [];

			Utils::setIfNotNull($checkSingleAgree->userid, 'userid', $args);
			Utils::setIfNotNull($checkSingleAgree->exteranalopenid, 'exteranalopenid', $args);

			return $args;
		}

		/**
		 * @param CheckSingleAgree $checkSingleAgree
		 *
		 * @throws \ParameterError
		 */
		public static function CheckArgs ($checkSingleAgree)
		{
			Utils::checkNotEmptyStr($checkSingleAgree->userid, 'userid');
			Utils::checkNotEmptyStr($checkSingleAgree->exteranalopenid, 'exteranalopenid');
		}
	}