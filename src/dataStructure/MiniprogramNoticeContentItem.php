<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/11
	 * Time: 15:37
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class MiniprogramNoticeContentItem
	 *
	 * @property string $key   长度10个汉字以内
	 * @property string $value 长度30个汉字以内
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MiniprogramNoticeContentItem
	{
		/**
		 * @param array $arr
		 *
		 * @return MiniprogramNoticeContentItem
		 */
		public static function parseFromArray ($arr)
		{
			$miniprogramNoticeContentItem = new MiniprogramNoticeContentItem();

			$miniprogramNoticeContentItem->key   = Utils::arrayGet($arr, 'key');
			$miniprogramNoticeContentItem->value = Utils::arrayGet($arr, 'value');

			return $miniprogramNoticeContentItem;
		}

		/**
		 * @param MiniprogramNoticeContentItem $args
		 *
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			Utils::checkNotEmptyStr($args->key);
			Utils::checkNotEmptyStr($args->value);

			if (mb_strlen($args->key, 'utf-8') > 10) {
				throw new \QyApiError('key must not more than 10');
			}

			if (mb_strlen($args->value, 'utf-8') > 30) {
				throw new \QyApiError('key must not more than 30');
			}
		}

		/**
		 * @param MiniprogramNoticeContentItem $item
		 *
		 * @return array
		 */
		public static function item2Array ($item)
		{
			$args = [];

			Utils::setIfNotNull($item->key, "key", $args);
			Utils::setIfNotNull($item->value, "value", $args);

			return $args;
		}
	}