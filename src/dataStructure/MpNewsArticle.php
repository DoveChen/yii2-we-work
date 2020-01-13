<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/9
	 * Time: 15:18
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class MpNewsArticle
	 *
	 * @property string $title              标题，不超过128个字节，超过会自动截断（支持id转译）
	 * @property string $thumb_media_id     图文消息缩略图的media_id, 可以通过素材管理接口获得。此处thumb_media_id即上传接口返回的media_id
	 * @property string $author             图文消息的作者，不超过64个字节
	 * @property string $content_source_url 图文消息点击“阅读原文”之后的页面链接
	 * @property string $content            图文消息的内容，支持html标签，不超过666 K个字节（支持id转译）
	 * @property string $digest             图文消息的描述，不超过512个字节，超过会自动截断（支持id转译）
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class MpNewsArticle
	{
		/**
		 * @param array $arr
		 *
		 * @return MpNewsArticle
		 */
		public static function parseFromArray ($arr)
		{
			$mpNewsArticle = new MpNewsArticle();

			$mpNewsArticle->title              = Utils::arrayGet($arr, 'title');
			$mpNewsArticle->thumb_media_id     = Utils::arrayGet($arr, 'thumb_media_id');
			$mpNewsArticle->author             = Utils::arrayGet($arr, 'author');
			$mpNewsArticle->content_source_url = Utils::arrayGet($arr, 'content_source_url');
			$mpNewsArticle->content            = Utils::arrayGet($arr, 'content');
			$mpNewsArticle->digest             = Utils::arrayGet($arr, 'digest');

			return $mpNewsArticle;
		}

		/**
		 * @param MpNewsArticle $sendArgs
		 *
		 * @throws \ParameterError
		 */
		public static function CheckMessageSendArgs ($sendArgs)
		{
			Utils::checkNotEmptyStr($sendArgs->title, "title");
			Utils::checkNotEmptyStr($sendArgs->thumb_media_id, "thumb_media_id");
			Utils::checkNotEmptyStr($sendArgs->content, "content");
		}

		/**
		 * @param MpNewsArticle $article
		 *
		 * @return array
		 */
		public static function Article2Array ($article)
		{
			$args = [];

			Utils::setIfNotNull($article->title, "title", $args);
			Utils::setIfNotNull($article->thumb_media_id, "thumb_media_id", $args);
			Utils::setIfNotNull($article->author, "author", $args);
			Utils::setIfNotNull($article->content_source_url, "content_source_url", $args);
			Utils::setIfNotNull($article->content, "content", $args);
			Utils::setIfNotNull($article->digest, "digest", $args);

			return $args;
		}
	}