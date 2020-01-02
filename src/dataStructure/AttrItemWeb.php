<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class AttrItemText
	 *
	 * @property string $url   网页的url,必须包含http或者https头
	 * @property string $title 网页的展示标题,长度限制12个UTF8字符
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class AttrItemWeb
	{
		/**
		 * @param array $arr
		 *
		 * @return AttrItemWeb
		 */
		public static function parseFromArray ($arr)
		{
			$attrItemWeb = new AttrItemWeb();

			$attrItemWeb->url   = Utils::arrayGet($arr, "url");
			$attrItemWeb->title = Utils::arrayGet($arr, "title");

			return $attrItemWeb;
		}
	}