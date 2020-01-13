<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/11
	 * Time: 16:25
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class TaskcardBtn
	 *
	 * @property string $key          按钮key值，用户点击后，会产生任务卡片回调事件，回调事件会带上该key值，只能由数字、字母和“_-@.”组成，最长支持128字节
	 * @property string $name         按钮名称
	 * @property string $replace_name 点击按钮后显示的名称，默认为“已处理”
	 * @property string $color        按钮字体颜色，可选“red”或者“blue”,默认为“blue”
	 * @property string $is_bold      按钮字体是否加粗，默认false
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class TaskcardBtn
	{
		/**
		 * @param array $arr
		 *
		 * @return TaskcardBtn
		 */
		public static function parseFromArray ($arr)
		{
			$btn = new TaskcardBtn();

			$btn->key          = Utils::arrayGet($arr, 'key');
			$btn->name         = Utils::arrayGet($arr, 'name');
			$btn->replace_name = Utils::arrayGet($arr, 'replace_name');
			$btn->color        = Utils::arrayGet($arr, 'color');
			$btn->is_bold      = Utils::arrayGet($arr, 'is_bold');

			return $btn;
		}

		/**
		 * @param TaskcardBtn $args
		 *
		 * @throws \ParameterError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			Utils::checkNotEmptyStr($args->key, "key");
			Utils::checkNotEmptyStr($args->name, "name");
		}

		/**
		 * @param TaskcardBtn $taskcardBtn
		 *
		 * @return array
		 */
		public static function taskcardBtn2Array ($taskcardBtn)
		{
			$args = [];

			Utils::setIfNotNull($taskcardBtn->key, "key", $args);
			Utils::setIfNotNull($taskcardBtn->name, "name", $args);
			Utils::setIfNotNull($taskcardBtn->replace_name, "replace_name", $args);
			Utils::setIfNotNull($taskcardBtn->color, "color", $args);
			Utils::setIfNotNull($taskcardBtn->is_bold, "is_bold", $args);

			return $args;
		}
	}