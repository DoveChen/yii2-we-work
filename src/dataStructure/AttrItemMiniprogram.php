<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class AttrItemMiniprogram
	 *
	 * @property string $appid    小程序appid，必须是有在本企业安装授权的小程序，否则会被忽略
	 * @property string $title    小程序的展示标题,长度限制12个UTF8字符
	 * @property string $pagepath 小程序的页面路径
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class AttrItemMiniprogram
	{
		/**
		 * @param array $arr
		 *
		 * @return AttrItemMiniprogram
		 */
		public static function parseFromArray ($arr)
		{
			$attrItemMiniprogram = new AttrItemMiniprogram();

			$attrItemMiniprogram->appid    = Utils::arrayGet($arr, "appid");
			$attrItemMiniprogram->title    = Utils::arrayGet($arr, "title");
			$attrItemMiniprogram->pagepath = Utils::arrayGet($arr, "pagepath");

			return $attrItemMiniprogram;
		}
	}