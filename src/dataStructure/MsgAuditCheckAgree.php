<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/5/28
	 * Time: 09:52
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;
	use SebastianBergmann\CodeCoverage\Util;

	/**
	 * Class MsgAudit
	 *
	 * @property array  info   待查询的会话信息，数组
	 * @property string roomid 待查询的roomid
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MsgAuditCheckAgree
	{
		/**
		 * @param $arr
		 *
		 * @return MsgAuditCheckAgree
		 */
		public static function parseFromArray ($arr)
		{
			$msgAuditCheckAgree = new self();

			$checkSingle = Utils::arrayGet($arr, 'info');
			if (!is_null($checkSingle)) {
				$msgAuditCheckAgree->info = [];
				foreach ($checkSingle as $singleInfo) {
					array_push($msgAuditCheckAgree->info, CheckSingleAgree::parseFromArray($singleInfo));
				}
			}

			$checkRoom = Utils::arrayGet($arr, 'roomid');
			if (!is_null($checkRoom)) {
				$msgAuditCheckAgree->roomid = $checkRoom;
			}

			return $msgAuditCheckAgree;
		}

		/**
		 * @param MsgAuditCheckAgree $msgAuditCheckAgree
		 *
		 * @return array
		 */
		public static function SetSingleAgreeArgs ($msgAuditCheckAgree)
		{
			$args = [
				'info' => []
			];

			foreach ($msgAuditCheckAgree->info as $item) {
				array_push($args['info'], CheckSingleAgree::ToArray($item));
			}

			return $args;
		}

		/**
		 * @param MsgAuditCheckAgree $msgAuditCheckAgree
		 *
		 * @throws \ParameterError
		 */
		public static function CheckSingleAgreeArgs ($msgAuditCheckAgree)
		{
			Utils::checkNotEmptyArray($msgAuditCheckAgree->info, 'info');
			foreach ($msgAuditCheckAgree->info as $info) {
				CheckSingleAgree::CheckArgs($info);
			}
		}

		/**
		 * @param MsgAuditCheckAgree $msgAuditCheckAgree
		 *
		 * @return array
		 */
		public static function SetRoomAgreeArgs ($msgAuditCheckAgree)
		{
			$args = [];

			Utils::setIfNotNull($msgAuditCheckAgree->roomid, 'roomid', $args);

			return $args;
		}

		/**
		 * @param MsgAuditCheckAgree $msgAuditCheckAgree
		 *
		 * @throws \ParameterError
		 */
		public static function CheckRoomAgreeArgs ($msgAuditCheckAgree)
		{
			Utils::checkNotEmptyStr($msgAuditCheckAgree->roomid, 'roomid');
		}
	}