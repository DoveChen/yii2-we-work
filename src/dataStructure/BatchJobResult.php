<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class BatchJobResult
	 *
	 * @property int    $status        任务状态，整型，1表示任务开始，2表示任务进行中，3表示任务已完成
	 * @property string $type          操作类型，字节串，目前分别有：1. sync_user(增量更新成员) 2. replace_user(全量覆盖成员)3. replace_party(全量覆盖部门)
	 * @property int    $total         任务运行总条数
	 * @property int    $percentage    目前运行百分比，当任务完成时为100
	 * @property array  $result        详细的处理结果，具体格式参考下面说明。当任务完成后此字段有效
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class BatchJobResult
	{
		const STATUS_STARTED = 1;
		const STATUS_PENDING = 2;
		const STATUS_FINISHED = 3;

		const TYPE_SYNC_USER = 1;
		const TYPE_REPLACE_USER = 2;
		const TYPE_REPLACE_PARTY = 3;

		/**
		 * @param array $arr
		 *
		 * @return BatchJobResult
		 */
		public static function parseFromArray ($arr)
		{
			$jobResult = new BatchJobResult();

			$jobResult->status     = Utils::arrayGet($arr, "status");
			$jobResult->type       = Utils::arrayGet($arr, "type");
			$jobResult->total      = Utils::arrayGet($arr, "total");
			$jobResult->percentage = Utils::arrayGet($arr, "percentage");

			$jobResult->result = [];
			$resultList        = Utils::arrayGet($arr, 'result');
			if (is_array($resultList)) {
				foreach ($resultList as $item) {
					if ($jobResult->type == static::TYPE_REPLACE_PARTY) {
						array_push($jobResult->result, BatchJobPartyResult::parseFromArray($item));
					} else {
						array_push($jobResult->result, BatchJobUserResult::parseFromArray($item));
					}
				}
			}

			return $jobResult;
		}
	}