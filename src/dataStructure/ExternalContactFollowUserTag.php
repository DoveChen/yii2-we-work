<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactFollowUserTag
	 *
	 * @property string $group_name 该成员添加此外部联系人所打标签的分组名称（标签功能需要企业微信升级到2.7.5及以上版本）
	 * @property string $tag_name   该成员添加此外部联系人所打标签名称
	 * @property int    $type       该成员添加此外部联系人所打标签类型, 1-企业设置, 2-用户自定义
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactFollowUserTag
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactFollowUserTag
		 */
		public static function parseFromArray ($arr)
		{
			$userTag = new ExternalContactFollowUserTag();

			$userTag->group_name = Utils::arrayGet($arr, 'group_name');
			$userTag->tag_name   = Utils::arrayGet($arr, 'tag_name');
			$userTag->type       = Utils::arrayGet($arr, 'type');

			return $userTag;
		}
	}