<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class Department
	 *
	 * @property int    $id          部门id，32位整型，指定时必须大于1。若不填该参数，将自动生成id
	 * @property string $name        部门名称。长度限制为1~32个字符，字符不能包括\:?”<>｜
	 * @property string $name_en     英文名称，需要在管理后台开启多语言支持才能生效。长度限制为1~32个字符，字符不能包括\:?”<>｜
	 * @property int    $parentid    父部门id，32位整型
	 * @property int    $order       在父部门中的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class Department
	{
		/**
		 * @param array $arr
		 *
		 * @return Department
		 */
		public static function parseFromArray ($arr)
		{
			$department = new Department();

			$department->id       = Utils::arrayGet($arr, 'id');
			$department->name     = Utils::arrayGet($arr, 'name');
			$department->name_en  = Utils::arrayGet($arr, 'name_en');
			$department->parentid = Utils::arrayGet($arr, 'parentid');
			$department->order    = Utils::arrayGet($arr, 'order');

			return $department;
		}

		/**
		 * @param Department $department
		 *
		 * @return array
		 */
		public static function department2Array ($department)
		{
			$arr = [];

			Utils::setIfNotNull($department->id, 'id', $arr);
			Utils::setIfNotNull($department->name, 'name', $arr);
			Utils::setIfNotNull($department->name_en, 'name_en', $arr);
			Utils::setIfNotNull($department->parentid, 'parentid', $arr);
			Utils::setIfNotNull($department->order, 'order', $arr);

			return $arr;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function Array2DepartmentList ($arr)
		{
			$list = Utils::arrayGet($arr, "department");

			$departmentList = [];
			if (is_array($list)) {
				foreach ($list as $item) {
					array_push($departmentList, static::parseFromArray($item));
				}
			}

			return $departmentList;
		}

		/**
		 * @param Department $department
		 *
		 * @throws \ParameterError
		 */
		public static function CheckDepartmentCreateArgs ($department)
		{
			Utils::checkNotEmptyStr($department->name, "department name");
			Utils::checkIsUInt($department->parentid, "parentid");
		}

		/**
		 * @param Department $department
		 *
		 * @throws \ParameterError
		 */
		public static function CheckDepartmentUpdateArgs ($department)
		{
			Utils::checkIsUInt($department->id, "department id");
		}
	}