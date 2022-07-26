<?php

	namespace dovechen\yii2\weWork;

	require_once "components/errorInc/error.inc.php";

	use dovechen\yii2\weWork\components\BaseWork;
	use dovechen\yii2\weWork\components\Utils;
	use yii\base\InvalidParamException;

	class ServiceProvider extends BaseWork
	{
		/**
		 * 每个服务商同时也是一个企业微信的企业，都有唯一的corpid。获取此信息可在服务商管理后台“应用开发”－“通用开发参数”可查看
		 * @var string
		 */
		public $provider_corpid;
		/**
		 * 作为服务商身份的调用凭证，应妥善保管好该密钥，务必不能泄漏。
		 * @var string
		 */
		public $provider_secret;
		/**
		 * 服务商的token
		 * @var string
		 */
		public $provider_access_token;
		/**
		 * 凭证的有效时间（秒）
		 * @var string
		 */
		public $provider_access_token_expire;

		/**
		 * 用于计算签名，由英文或数字组成且长度不超过32位的自定义字符串。
		 * @var string
		 */
		public $token;
		/**
		 * 用于消息内容加密，由英文或数字组成且长度为43位的自定义字符串。
		 * @var string
		 */
		public $encodingAesKey;

		/**
		 * 数据缓存前缀
		 * @var string
		 */
		public $cachePrefix = 'cache_work_provider';

		/**
		 * @throws \ParameterError
		 */
		public function init ()
		{
			Utils::checkNotEmptyStr($this->provider_corpid, 'provider_corpid');
			Utils::checkNotEmptyStr($this->provider_secret, 'provider_secret');
		}

		/**
		 * 获取缓存键值
		 *
		 * @param $name
		 *
		 * @return string
		 */
		protected function getCacheKey ($name)
		{
			return $this->cachePrefix . '_' . $this->provider_corpid . '_' . $name;
		}

		public function GetProviderAccessToken ($force = false)
		{
			$time = time();
			if (!Utils::notEmptyStr($this->provider_access_token) || $this->provider_access_token_expire < $time || $force) {
				$result = !Utils::notEmptyStr($this->provider_access_token) && !$force ? $this->getCache("provider_access_token", false) : false;
				if ($result === false) {
					$result = $this->RefreshProviderAccessToken();
				} else {
					if ($result['expire'] < $time) {
						$result = $this->RefreshProviderAccessToken();
					}
				}

				$this->SetProviderAccessToken($result);
			}

			return $this->provider_access_token;
		}

		protected function RefreshProviderAccessToken ()
		{

			if (!Utils::notEmptyStr($this->provider_corpid) || !Utils::notEmptyStr($this->provider_secret)) {
				throw new \ParameterError("invalid provider_corpid or provider_secret");
			}

			$time = time();
			$this->_HttpCall(self::SERVICE_GET_PROVIDER_TOKEN, 'POST', ['corpid' => $this->provider_corpid, 'provider_secret' => $this->provider_secret]);

			$this->repJson['expire'] = $time + $this->repJson["expires_in"];
			$this->setCache('provider_access_token', $this->repJson, $this->repJson['expires_in']);

			return $this->repJson;
		}

		public function SetProviderAccessToken (array $providerAccessToken)
		{
			if (!isset($providerAccessToken['provider_access_token'])) {
				throw new InvalidParamException('The service provider_access_token must be set.');
			} elseif (!isset($providerAccessToken['expire'])) {
				throw new InvalidParamException('Service provider_access_token expire time must be set.');
			}
			$this->provider_access_token        = $providerAccessToken['provider_access_token'];
			$this->provider_access_token_expire = $providerAccessToken['expire'];
		}

		public function getLoginInfo ($authCode)
		{
			self::_HttpCall(self::SERVICE_GET_LOGIN_INFO, 'POST', ['auth_code' => $authCode]);

			return $this->repJson;
		}

		public function getRegisterCode ($args)
		{
			self::_HttpCall(self::SERVICE_GET_REGISTER_CODE, 'POST', $args);

			return $this->repJson;
		}

		public function getRegisterInfo ($registerCode)
		{
			self::_HttpCall(self::SERVICE_GET_REGISTER_INFO, 'POST', ['register_code' => $registerCode]);

			return $this->repJson;
		}

		public function setScope ($accessToken, $args)
		{
			self::_HttpCall(self::AGENT_SET_SCOPE . $accessToken, "GET", $args);

			return $this->repJson;
		}

		public function contactSyncSuccess ($accessToken)
		{
			self::_HttpCall(self::SYNC_CONTACT_SYNC_SUCCESS . $accessToken);

			return $this->repJson;
		}

		public function finishExternalUseridMigration ($corpid)
		{
			Utils::checkNotEmptyStr($corpid, 'corpid');

			self::_HttpCall(self::FINISH_EXTERNAL_USERID_MIGRATION, 'POST', ['corpid' => $corpid]);

			return $this->repJson;
		}

		public function corpidToOpencorpid ($corpid)
		{
			Utils::checkNotEmptyStr($corpid, 'corpid');

			self::_HttpCall(self::CORPID_TO_OPENCORPID, 'POST', ['corpid' => $corpid]);

			return $this->repJson;
		}
	}