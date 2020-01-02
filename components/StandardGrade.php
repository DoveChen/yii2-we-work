<?php

	namespace dovechen\yii2\weWork\components;

	/**
	 * Class StandardGrade
	 * @package dovechen\yii2\weWork\components
	 */
	class StandardGrade
	{
		public $gradeCode
			= [
				'0'  => '非标准年级',
				'1'  => '幼儿园小小班',
				'2'  => '幼儿园小班',
				'3'  => '幼儿园中班',
				'4'  => '幼儿园大班',
				'5'  => '幼儿园学前班',
				'31' => '小学一年级',
				'32' => '小学二年级',
				'33' => '小学三年级',
				'34' => '小学四年级',
				'35' => '小学五年级',
				'36' => '小学六年级',
				'37' => '小学七年级',
				'38' => '小学八年级',
				'39' => '小学九年级',
				'61' => '初中一年级',
				'62' => '初中二年级',
				'63' => '初中三年级',
				'64' => '初中四年级',
				'91' => '高中一年级',
				'92' => '高中二年级',
				'93' => '高中三年级',
				'94' => '高中四年级',
			];

		public $gradeInfo
			= [
				'非标准年级'  => 0,
				'幼儿园小小班' => 1,
				'幼儿园小班'  => 2,
				'幼儿园中班'  => 3,
				'幼儿园大班'  => 4,
				'幼儿园学前班' => 5,
				'小学一年级'  => 31,
				'小学二年级'  => 32,
				'小学三年级'  => 33,
				'小学四年级'  => 34,
				'小学五年级'  => 35,
				'小学六年级'  => 36,
				'小学七年级'  => 37,
				'小学八年级'  => 38,
				'小学九年级'  => 39,
				'初中一年级'  => 61,
				'初中二年级'  => 62,
				'初中三年级'  => 63,
				'初中四年级'  => 64,
				'高中一年级'  => 91,
				'高中二年级'  => 92,
				'高中三年级'  => 93,
				'高中四年级'  => 94,
			];

		/**
		 * @param string $grade
		 *
		 * @return int|null
		 */
		public static function getGradeCode ($grade)
		{
			$standardGrade = new StandardGrade();

			return Utils::arrayGet($standardGrade->gradeInfo, $grade);
		}

		/**
		 * @param string|int $gradeCode
		 *
		 * @return string|null
		 */
		public static function getGradeInfo ($gradeCode)
		{
			$standardGrade = new StandardGrade();

			return Utils::arrayGet($standardGrade->gradeCode, $gradeCode);
		}
	}