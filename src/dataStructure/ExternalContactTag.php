<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactTag
	 *
	 * @property string  $id             标签id
	 * @property string  $name           标签名称
	 * @property string  $create_time    标签创建时间
	 * @property string  $order          标签排序的次序值，order值大的排序靠前。有效的值范围是[0, 2^32)
	 * @property boolean $deleted        标签是否已经被删除，只在指定tag_id进行查询时返回
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactTag
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactTag
		 */
		public static function parseFromArray ($arr)
		{
			$ECTag = new ExternalContactTag();

			$ECTag->id          = Utils::arrayGet($arr, 'id');
			$ECTag->name        = Utils::arrayGet($arr, 'name');
			$ECTag->create_time = Utils::arrayGet($arr, 'create_time');
			$ECTag->order       = Utils::arrayGet($arr, 'order');
			$ECTag->deleted     = Utils::arrayGet($arr, 'deleted');

			return $ECTag;
		}

		/**
		 * @param ExternalContactTag $tag
		 *
		 * @throws \ParameterError
		 */
		public static function checkExternalContactTagAddArgs ($tag)
		{
			Utils::checkNotEmptyStr($tag->name, 'tag name');
		}

		/**
		 * @param ExternalContactTag $tag
		 *
		 * @throws \ParameterError
		 */
		public static function checkExternalContactTagEditArgs ($tag)
		{
			Utils::checkNotEmptyStr($tag->id, 'tag id');

			if (!Utils::notEmptyStr($tag->name) && !Utils::notEmptyStr($tag->order)) {
				throw new \ParameterError('input error paramter.');
			}
		}
	}