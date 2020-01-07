<?php

	namespace dovechen\yii2\weWork;

	use dovechen\yii2\weWork\components\Utils;
	use dovechen\yii2\weWork\src\dataStructure\UserDetailByUserTicket;
	use dovechen\yii2\weWork\src\dataStructure\UserInfoByCode;
	use yii\base\InvalidParamException;

	class ServiceWork extends Work
	{
		/**
		 * 为应用的唯一身份标识
		 * @var string
		 */
		public $suite_id;
		/**
		 * 为对应的调用身份密钥。
		 * @var string
		 */
		public $suite_secret;
		/**
		 * 企业微信服务器会定时（每十分钟）推送ticket。ticket会实时变更，并用于后续接口的调用。
		 * @var string
		 */
		public $suite_ticket;
		/**
		 * 第三方应用的token
		 * @var string
		 */
		public $suite_access_token;
		/**
		 * 凭证的有效时间（秒）
		 * @var string
		 */
		public $suite_access_token_expire;
		/**
		 * 授权方corpid
		 * @var string
		 */
		public $auth_corpid;
		/**
		 * 预授权码
		 * @var string
		 */
		public $pre_auth_code;
		/**
		 * 预授权码有效期
		 * @var string
		 */
		public $pre_auth_code_expires;
		/**
		 * 永久授权码，通过get_permanent_code获取
		 * @var string
		 */
		public $permanent_code;
		/**
		 * 数据缓存前缀
		 * @var string
		 */
		protected $cachePrefix = 'cache_work_suite';

		/**
		 * @throws \ParameterError
		 */
		public function init ()
		{
			Utils::checkNotEmptyStr($this->suite_id, 'suite_id');
			Utils::checkNotEmptyStr($this->suite_secret, 'suite_secret');
			Utils::checkNotEmptyStr($this->suite_ticket, 'suite_ticket');
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
			return $this->cachePrefix . '_' . $this->auth_corpid . '_' . $name;
		}

		protected function RefreshAccessToken ()
		{

			if (!Utils::notEmptyStr($this->auth_corpid) || !Utils::notEmptyStr($this->permanent_code)) {
				throw new \ParameterError("invalid auth_corpid or permanent_code");
			}

			$time = time();
			$this->_HttpCall(self::SERVICE_GET_CORP_TOKEN, 'POST', ['auth_corpid' => $this->auth_corpid, 'permanent_code' => $this->permanent_code]);

			$this->repJson['expire'] = $time + $this->repJson["expires_in"];
			$this->setCache('access_token', $this->repJson, $this->repJson['expires_in']);

			return $this->repJson;
		}

		public function GetSuiteAccessToken ($force = false)
		{
			$time = time();
			if (!Utils::notEmptyStr($this->suite_access_token) || $this->suite_access_token_expire < $time || $force) {
				$result = !Utils::notEmptyStr($this->suite_access_token) && !$force ? $this->getCache("suite_access_token", false) : false;
				if ($result === false) {
					$result = $this->RefreshSuiteAccessToken();
				} else {
					if ($result['expire'] < $time) {
						$result = $this->RefreshSuiteAccessToken();
					}
				}

				$this->SetSuiteAccessToken($result);
			}

			return $this->suite_access_token;
		}

		protected function RefreshSuiteAccessToken ()
		{
			if (!Utils::notEmptyStr($this->suite_id) || !Utils::notEmptyStr($this->suite_secret) || !Utils::notEmptyStr($this->suite_ticket)) {
				throw new \ParameterError("invalid suite_id or suite_secret or suite_ticket");
			}

			$time = time();
			$this->_HttpCall(self::SERVICE_GET_SUITE_TOKEN, 'POST', ['suite_id' => $this->suite_id, 'suite_secret' => $this->suite_secret, 'suite_ticket' => $this->suite_ticket]);

			$this->repJson['expire'] = $time + $this->repJson["expires_in"];
			$this->setCache('suite_access_token', $this->repJson, $this->repJson['expires_in']);

			return $this->repJson;
		}

		public function SetSuiteAccessToken (array $suiteAccessToken)
		{
			if (!isset($suiteAccessToken['suite_access_token'])) {
				throw new InvalidParamException('The suite suite_access_token must be set.');
			} elseif (!isset($suiteAccessToken['expire'])) {
				throw new InvalidParamException('Suite suite_access_token expire time must be set.');
			}
			$this->suite_access_token        = $suiteAccessToken['suite_access_token'];
			$this->suite_access_token_expire = $suiteAccessToken['expire'];
		}

		protected function GetAgentOauth2Url ($appid, $redirectUri, $state, $scope = self::SNSAPI_BASE, $agentId = '')
		{
			if ($scope == self::SNSAPI_BASE) {
				return $this->GetOauth2Url($appid, $redirectUri, $state, $scope);
			} else {
				return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&agentid={$agentId}&state={$state}#wechat_redirect";
			}
		}

		public function getAuthUrl ($redirectUri, $state, $authType = 0)
		{
			$time = time();

			if (!Utils::notEmptyStr($this->pre_auth_code) || $this->pre_auth_code_expires < $time) {
				$result = !Utils::notEmptyStr($this->pre_auth_code) ? $this->getCache("pre_auth_code", false) : false;
				if ($result === false) {
					$result = $this->getPreAuthCode();
				} else {
					if ($result['expire'] < $time) {
						$result = $this->getPreAuthCode();
					}
				}

				$this->setPreAuthCode($result);
			}

			if ($authType != 0) {
				$this->setSessionInfo($this->pre_auth_code, ['auth_type' => 1]);
			}

			return "https://open.work.weixin.qq.com/3rdapp/install?suite_id={$this->suite_id}&pre_auth_code={$this->pre_auth_code}&redirect_uri={$redirectUri}&state={$state}";
		}

		public function getPreAuthCode ()
		{
			$time = time();

			self::_HttpCall(self::SERVICE_GET_PRE_AUTH_CODE);

			$this->repJson['expire'] = $time + $this->repJson["expires_in"];
			$this->setCache('pre_auth_code', $this->repJson, $this->repJson['expires_in']);

			return $this->repJson;
		}

		public function setPreAuthCode (array $preAuthCode)
		{
			if (!isset($preAuthCode['pre_auth_code'])) {
				throw new InvalidParamException('The suite pre_auth_code must be set.');
			} elseif (!isset($preAuthCode['expire'])) {
				throw new InvalidParamException('Suite pre_auth_code expire time must be set.');
			}
			$this->pre_auth_code         = $preAuthCode['pre_auth_code'];
			$this->pre_auth_code_expires = $preAuthCode['expire'];
		}

		public function setSessionInfo ($preAuthCode, $sessionInfo)
		{
			$args = [
				'pre_auth_code' => $preAuthCode,
				'session_info'  => $sessionInfo,
			];

			self::_HttpCall(self::SERVICE_SET_SESSION_INFO, 'POST', $args);

			return $this->repJson;
		}

		public function getPermanentCode ($authCode)
		{
			self::_HttpCall(self::SERVICE_GET_PERMANENT_CODE, 'POST', ['auth_code' => $authCode]);

			return $this->repJson;
		}

		public function getAuthInfo ($authCorpId, $permanentCode)
		{
			$args = [
				'auth_corpid'    => $authCorpId,
				'permanent_code' => $permanentCode,
			];

			self::_HttpCall(self::SERVICE_GET_AUTH_INFO, 'POST', $args);

			return $this->repJson;
		}

		public function getAdminList ($authCorpId, $agentId)
		{
			$args = [
				'auth_corpid' => $authCorpId,
				'agentid'     => $agentId,
			];

			self::_HttpCall(self::SERVICE_GET_ADMIN_LIST, 'POST', $args);

			return $this->repJson;
		}

		public function getUserInfo3rd ($code)
		{
			Utils::checkNotEmptyStr($code, "code");
			self::_HttpCall(self::SERVICE_GET_USER_INFO, 'GET', ['code' => $code]);

			return UserInfoByCode::parseFromArray($this->repJson);
		}

		public function getUserDetail3rd ($userTicket)
		{
			Utils::checkNotEmptyStr($userTicket, "user_ticket");
			self::_HttpCall(self::SERVICE_GET_USER_DETIAL, 'GET', ['user_ticket' => $userTicket]);

			return UserDetailByUserTicket::parseFromArray($this->repJson);
		}
	}