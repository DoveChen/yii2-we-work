<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class AttrItem
	 *
	 * @property int    $type        属性类型: 0-文本 1-网页 2-小程序
	 * @property string $name        属性名称：需要先确保在管理端有创建该属性，否则会忽略
	 * @property string $text        文本类型的属性 type为0时必填
	 * @property string $web         网页类型的属性，url和title字段要么同时为空表示清除该属性，要么同时不为空 type为1时必填
	 * @property string $miniprogram 小程序类型的属性，appid和title字段要么同时为空表示清除改属性，要么同时不为空 type为2时必填
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class AttrItem
	{
		/**
		 * @param array $arr
		 *
		 * @return AttrItem
		 */
		public static function parseFromArray ($arr)
		{
			$attrItem = new AttrItem();

			$attrItem->type = Utils::arrayGet($arr, "type");
			$attrItem->name = Utils::arrayGet($arr, "name");

			switch ($attrItem->type) {
				case 0:
					$attrItem->text = AttrItemText::parseFromArray(Utils::arrayGet($arr, 'text'));

					break;
				case 1:
					$attrItem->web = AttrItemWeb::parseFromArray(Utils::arrayGet($arr, 'web'));

					break;
				case 2:
					$attrItem->miniprogram = AttrItemMiniprogram::parseFromArray(Utils::arrayGet($arr, 'miniprogram'));

					break;
			}

			return $attrItem;
		}
	}