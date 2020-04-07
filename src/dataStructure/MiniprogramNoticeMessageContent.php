<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/11
	 * Time: 15:57
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class MiniprogramNoticeMessageContent
	 *
	 * @property string  $msgtype             消息类型，此时固定为：miniprogram_notice
	 * @property string  $appid               小程序appid，必须是与当前小程序应用关联的小程序
	 * @property string  $page                点击消息卡片后的小程序页面，仅限本小程序内的页面。该字段不填则消息点击后不跳转。
	 * @property string  $title               消息标题，长度限制4-12个汉字
	 * @property string  $description         消息描述，长度限制4-12个汉字
	 * @property boolean $emphasis_first_item 是否放大第一个content_item
	 * @property string  $content_item        消息内容键值对，最多允许10个item
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MiniprogramNoticeMessageContent
	{
		const MSG_TYPE = 'miniprogram_notice';

		/**
		 * @param $arr
		 *
		 * @return MiniprogramNoticeMessageContent
		 */
		public static function parseFromArray ($arr)
		{
			$content = new MiniprogramNoticeMessageContent();

			$content->msgtype             = static::MSG_TYPE;
			$content->appid               = Utils::arrayGet($arr, 'appid');
			$content->page                = Utils::arrayGet($arr, 'page');
			$content->title               = Utils::arrayGet($arr, 'title');
			$content->description         = Utils::arrayGet($arr, 'description');
			$content->emphasis_first_item = Utils::arrayGet($arr, 'emphasis_first_item');
			$content->content_item        = [];

			$contentItem = Utils::arrayGet($arr, 'content_item');
			if (!is_null($contentItem)) {
				foreach ($contentItem as $item) {
					array_push($content->content_item, MiniprogramNoticeContentItem::parseFromArray($item));
				}
			}

			return $content;
		}

		/**
		 * @param MiniprogramNoticeMessageContent $args
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			Utils::checkNotEmptyStr($args->msgtype, 'msgtype');

			if ($args->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			Utils::checkNotEmptyStr($args->appid, 'appid');
			Utils::checkNotEmptyStr($args->title, 'title');

			if (mb_strlen($args->title, 'utf-8') < 4 || mb_strlen($args->title, 'utf-8') > 12) {
				throw new \QyApiError('title must between 4 and 12');
			}

			if (!empty($args->description)) {
				if (mb_strlen($args->description, 'utf-8') < 4 || mb_strlen($args->description, 'utf-8') > 12) {
					throw new \QyApiError('description must between 4 and 12');
				}
			}

			if (!empty($args->content_item)) {
				foreach ($args->content_item as $contentItem) {
					MiniprogramNoticeContentItem::CheckMessageSendArgs($contentItem);
				}
			}
		}

		/**
		 * @param MiniprogramNoticeMessageContent $content
		 * @param                                 $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$args = [];
			Utils::setIfNotNull($content->appid, "appid", $args);
			Utils::setIfNotNull($content->page, "page", $args);
			Utils::setIfNotNull($content->title, "title", $args);
			Utils::setIfNotNull($content->description, "description", $args);
			Utils::setIfNotNull($content->emphasis_first_item, "emphasis_first_item", $args);

			if (!empty($content->content_item)) {
				$args['content_item'] = [];

				foreach ($content->content_item as $item) {
					array_push($args['content_item'], MiniprogramNoticeContentItem::item2Array($item));
				}
			}

			Utils::setIfNotNull($args, $content->msgtype, $arr);
		}
	}