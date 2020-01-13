<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/11
	 * Time: 15:05
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class NewsArticle
	 *
	 * @property string $title       标题，不超过128个字节，超过会自动截断（支持id转译）
	 * @property string $description 描述，不超过512个字节，超过会自动截断（支持id转译）
	 * @property string $url         点击后跳转的链接。
	 * @property string $picurl      图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图 1068*455，小图150*150。
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class NewsArticle
	{
		/**
		 * @param array $arr
		 *
		 * @return NewsArticle
		 */
		public static function parseFromArray ($arr)
		{
			$newArticle = new NewsArticle();

			$newArticle->title       = Utils::arrayGet($arr, 'title');
			$newArticle->description = Utils::arrayGet($arr, 'description');
			$newArticle->url         = Utils::arrayGet($arr, 'url');
			$newArticle->picurl      = Utils::arrayGet($arr, 'picurl');

			return $newArticle;
		}

		/**
		 * @param NewsArticle $args
		 *
		 * @throws \ParameterError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			Utils::checkNotEmptyStr($args->title, "title");
			Utils::checkNotEmptyStr($args->url, "url");
		}

		/**
		 * @param NewsArticle $newArticle
		 *
		 * @return array
		 */
		public static function Article2Array ($newArticle)
		{
			$args = [];

			Utils::setIfNotNull($newArticle->title, "title", $args);
			Utils::setIfNotNull($newArticle->description, "description", $args);
			Utils::setIfNotNull($newArticle->url, "url", $args);
			Utils::setIfNotNull($newArticle->picurl, "picurl", $args);

			return $args;
		}
	}