<?php
	include_once __DIR__ . "/../errorInc/error.inc.php";

	/**
	 * Class Utils
	 */
	class Utils
	{

		/**
		 * @param $var
		 *
		 * @return bool
		 */
		public static function notEmptyStr ($var)
		{
			return is_string($var) && ($var != "");
		}

		/**
		 * @param array $arr
		 *
		 * @return bool
		 */
		public static function notEmptyArray ($arr)
		{
			return is_array($arr) && count($arr) > 0;
		}

		/**
		 * @param $var
		 * @param $name
		 *
		 * @throws ParameterError
		 */
		public static function checkNotEmptyStr ($var, $name)
		{
			if (!self::notEmptyStr($var))
				throw new ParameterError($name . " can not be empty string");
		}

		/**
		 * @param $var
		 * @param $name
		 *
		 * @throws ParameterError
		 */
		public static function checkIsUInt ($var, $name)
		{
			if (!(is_int($var) && $var >= 0))
				throw new ParameterError($name . " need unsigned int");
		}

		/**
		 * @param $var
		 * @param $name
		 *
		 * @throws ParameterError
		 */
		public static function checkNotEmptyArray ($var, $name)
		{
			if (!is_array($var) || count($var) == 0) {
				throw new ParameterError($name . " can not be empty array");
			}
		}

		/**
		 * @param $var
		 * @param $name
		 * @param $args
		 */
		public static function setIfNotNull ($var, $name, &$args)
		{
			if (!is_null($var)) {
				$args[$name] = $var;
			}
		}

		/**
		 * @param      $array
		 * @param      $key
		 * @param null $default
		 *
		 * @return mixed|null
		 */
		public static function arrayGet ($array, $key, $default = NULL)
		{
			if (array_key_exists($key, $array))
				return $array[$key];

			return $default;
		}

		/**
		 * 数组 转 对象
		 *
		 * @param array $arr 数组
		 *
		 * @return object|void
		 */
		public static function Array2Object ($arr)
		{
			if (gettype($arr) != 'array') {
				return;
			}
			foreach ($arr as $k => $v) {
				if (gettype($v) == 'array' || getType($v) == 'object') {
					$arr[$k] = (object) self::Array2Object($v);
				}
			}

			return (object) $arr;
		}

		/**
		 * 对象 转 数组
		 *
		 * @param object $object 对象
		 *
		 * @return array
		 */
		public static function Object2Array ($object)
		{
			if (is_object($object) || is_array($object)) {
				$array = [];
				foreach ($object as $key => $value) {
					if ($value == NULL)
						continue;
					$array[$key] = self::Object2Array($value);
				}

				return $array;
			} else {
				return $object;
			}
		}

		/**
		 * 对象 转 数组 空时不过滤
		 *
		 * @param object $object 对象
		 *
		 * @return array
		 */
		public static function Object2EmptyArray ($object)
		{
			if (is_object($object) || is_array($object)) {
				$array = [];
				foreach ($object as $key => $value) {
					$array[$key] = self::Object2EmptyArray($value);
				}

				return $array;
			} else {
				return $object;
			}
		}

		/**
		 * 数组转XML
		 *
		 * @param       $rootName
		 * @param array $arr
		 *
		 * @return string
		 */
		public static function Array2Xml ($rootName, $arr)
		{
			$xml = "<" . $rootName . ">";
			foreach ($arr as $key => $val) {
				if (is_numeric($val)) {
					$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
				} else {
					$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
				}
			}
			$xml .= "</" . $rootName . ">";

			return $xml;
		}

		/**
		 * 将XML转为array
		 *
		 * @param $xml
		 *
		 * @return mixed|array
		 */
		public static function Xml2Array ($xml)
		{
			//禁止引用外部xml实体
			libxml_disable_entity_loader(true);
			$values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

			return $values;
		}

	}
