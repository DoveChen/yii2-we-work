<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class BatchJobUserResult
	 *
	 * @property string $userid    成员UserID。对应管理端的帐号
	 * @property int    $errcode   该成员对应操作的结果错误码
	 * @property string $errmsg    错误信息，例如无权限错误，键值冲突，格式错误等
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class BatchJobUserResult
	{
		/**
		 * @param array $arr
		 *
		 * @return BatchJobUserResult
		 */
		public static function parseFromArray ($arr)
		{
			$jobUserResult = new BatchJobUserResult();

			$jobUserResult->userid  = Utils::arrayGet($arr, "userid");
			$jobUserResult->errcode = Utils::arrayGet($arr, "errcode");
			$jobUserResult->errmsg  = Utils::arrayGet($arr, "errmsg");

			return $jobUserResult;
		}
	}