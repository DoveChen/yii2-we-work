<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class Batch
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class Batch
	{
		/**
		 * @param BatchJobArgs $batchJobArgs
		 *
		 * @throws \ParameterError
		 */
		public static function CheckBatchJobArgs ($batchJobArgs)
		{
			Utils::checkNotEmptyStr($batchJobArgs->media_id, "media_id");
		}

		/**
		 * @param $arr
		 *
		 * @return array BatchJobResult
		 */
		public static function parseFromArray ($arr)
		{
			$batchJobResult = BatchJobResult::parseFromArray($arr);

			return $batchJobResult;
		}

		/**
		 * @param BatchJobResult $batchJobResult
		 *
		 * @return bool
		 */
		public static function isJobFinished ($batchJobResult)
		{
			return !is_null($batchJobResult->status) && $batchJobResult->status == BatchJobResult::STATUS_FINISHED;
		}
	}