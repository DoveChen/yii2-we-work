<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class BatchCallback
	 *
	 * @property string $url            企业应用接收企业微信推送请求的访问协议和地址，支持http或https协议
	 * @property string $token          用于生成签名
	 * @property string $encodingaeskey 用于消息体的加密，是AES密钥的Base64编码
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class BatchCallback
	{
		/**
		 * @param $arr
		 *
		 * @return BatchCallback
		 */
		public static function parseFromArray ($arr)
		{
			$callback = new BatchCallback();

			$callback->url            = Utils::arrayGet($arr, 'url');
			$callback->token          = Utils::arrayGet($arr, 'token');
			$callback->encodingaeskey = Utils::arrayGet($arr, 'encodingaeskey');

			return $callback;
		}
	}