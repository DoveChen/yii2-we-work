<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class BatchJobPartyResult
	 *
	 * @property int    $action     操作类型（按位或）：1 新建部门 ，2 更改部门名称， 4 移动部门， 8 修改部门排序
	 * @property int    $partyid    部门ID
	 * @property int    $errcode    该部门对应操作的结果错误码
	 * @property string $errmsg     错误信息，例如无权限错误，键值冲突，格式错误等
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class BatchJobPartyResult
	{
		const ACTION_ADD = 1;
		const ACTION_MODIFY = 2;
		const ACTION_MOVE = 4;
		const ACTION_SORT = 8;

		/**
		 * @param array $arr
		 *
		 * @return BatchJobPartyResult
		 */
		public static function parseFromArray ($arr)
		{
			$jobPartyResult = new BatchJobPartyResult();

			$jobPartyResult->action  = Utils::arrayGet($arr, "action");
			$jobPartyResult->partyid = Utils::arrayGet($arr, "partyid");
			$jobPartyResult->errcode = Utils::arrayGet($arr, "errcode");
			$jobPartyResult->errmsg  = Utils::arrayGet($arr, "errmsg");

			return $jobPartyResult;
		}
	}