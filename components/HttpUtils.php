<?php

	namespace dovechen\yii2\weWork\components;

	require_once "utils/HttpUtils.php";

	/**
	 * Class HttpUtils
	 * @package dovechen\yii2\weWork\components
	 */
	class HttpUtils extends \HttpUtils
	{
		/**
		 * Returns the fully qualified name of this class.
		 * @return string The fully qualified name of this class.
		 */
		public static function className ()
		{
			return get_called_class();
		}
	}