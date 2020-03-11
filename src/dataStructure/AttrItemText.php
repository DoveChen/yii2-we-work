<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class AttrItemText
	 *
	 * @property string $value 文本属性内容,长度限制12个UTF8字符
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class AttrItemText
	{
		/**
		 * @param array $arr
		 *
		 * @return AttrItemText
		 */
		public static function parseFromArray ($arr)
		{
			$attrItemText = new AttrItemText();

			$attrItemText->value = Utils::arrayGet($arr, "value");

			return $attrItemText;
		}
	}