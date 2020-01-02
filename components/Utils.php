<?php

	namespace dovechen\yii2\weWork\components;

	require_once "utils/Utils.php";

	/**
	 * Class Utils
	 * @package dovechen\yii2\weWork\components
	 */
	class Utils extends \Utils
	{
		/**
		 * Returns the fully qualified name of this class.
		 * @return string The fully qualified name of this class.
		 */
		public static function classname ()
		{
			return get_called_class();
		}
	}