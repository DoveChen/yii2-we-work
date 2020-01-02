<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class TagUser
	 *
	 * @property string $userid 成员帐号
	 * @property string $name   成员名称，此字段从2019年12月30日起，对新创建第三方应用不再返回，2020年6月30日起，对所有历史第三方应用不再返回，后续第三方仅通讯录应用可获取，第三方页面需要通过通讯录展示组件来展示名字
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class TagUser
	{
		/**
		 * @param array $arr
		 *
		 * @return TagUser
		 */
		public static function parseFromArray ($arr)
		{
			$tagUser = new TagUser();

			$tagUser->userid = Utils::arrayGet($arr, "userid");
			$tagUser->name   = Utils::arrayGet($arr, "name");

			return $tagUser;
		}
	}