<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class Attr
	 *
	 * @property $attrs 自定义字段
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class Attr
	{
		/**
		 * @param array $arr
		 *
		 * @return Attr
		 */
		public static function parseFromArray ($arr)
		{
			$attr = new Attr();

			$attr->attrs = [];

			$attrInfo = Utils::arrayGet($arr, 'attrs');
			if (!is_null($attrInfo) && !empty($attrInfo)) {
				foreach ($attrInfo as $item) {
					array_push($attr->attrs, AttrItem::parseFromArray($item));
				}
			}

			return $attr;
		}
	}