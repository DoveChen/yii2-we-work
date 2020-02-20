<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactTagGroup
	 *
	 * @property string $group_id       标签组id
	 * @property string $group_name     标签组名称
	 * @property string $create_time    标签组创建时间
	 * @property int    $order          标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
	 * @property int    $deleted        标签组是否已经被删除，只在指定tag_id进行查询时返回
	 * @property array  $tag            标签组内的标签列表
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactTagGroup
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactTagGroup
		 */
		public static function parseFromArray ($arr)
		{
			$ECTagGroup = new ExternalContactTagGroup();

			$ECTagGroup->group_id    = Utils::arrayGet($arr, 'group_id');
			$ECTagGroup->group_name  = Utils::arrayGet($arr, 'group_name');
			$ECTagGroup->create_time = Utils::arrayGet($arr, 'create_time');
			$ECTagGroup->order       = Utils::arrayGet($arr, 'order');
			$ECTagGroup->tag         = [];

			$ECTags = Utils::arrayGet($arr, 'tag');
			if (Utils::notEmptyArray($ECTags)) {
				foreach ($ECTags as $item) {
					array_push($ECTagGroup->tag, ExternalContactTag::parseFromArray($item));
				}
			}

			return $ECTagGroup;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function arrayToTagGroup ($arr)
		{
			$tagGroupList = [];

			$tagGroup = Utils::arrayGet($arr, 'tag_group');

			if (Utils::notEmptyArray($tagGroup)) {
				foreach ($tagGroup as $item) {
					array_push($tagGroupList, self::parseFromArray($item));
				}
			}

			return $tagGroupList;
		}

		/**
		 * @param ExternalContactTagGroup $tagGroup
		 *
		 * @throws \ParameterError
		 */
		public static function checkExternalContactTagGroupAddArgs ($tagGroup)
		{
			if (!Utils::notEmptyStr($tagGroup->group_id) && !Utils::notEmptyStr($tagGroup->group_name)) {
				throw new \ParameterError('group_id and group_name must be has one.');
			};

			Utils::checkNotEmptyArray($tagGroup->tag, 'tag');

			foreach ($tagGroup->tag as $tag) {
				ExternalContactTag::checkExternalContactTagAddArgs($tag);
			}
		}
	}