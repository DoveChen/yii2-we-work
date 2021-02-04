<?php

	namespace dovechen\yii2\weWork;

	require_once "components/errorInc/error.inc.php";

	use dovechen\yii2\weWork\components\BaseWork;
	use dovechen\yii2\weWork\src\dataStructure\Agent;
	use dovechen\yii2\weWork\src\dataStructure\Batch;
	use dovechen\yii2\weWork\src\dataStructure\BatchJobArgs;
	use dovechen\yii2\weWork\src\dataStructure\Department;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContact;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactBatchGetByUser;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactBehavior;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactGroupChat;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactMsgTemplate;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactRemark;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactTag;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactTagGroup;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactUnAssignUser;
	use dovechen\yii2\weWork\src\dataStructure\ExternalContactWay;
	use dovechen\yii2\weWork\src\dataStructure\LinkedcorpMessage;
	use dovechen\yii2\weWork\src\dataStructure\Message;
	use dovechen\yii2\weWork\src\dataStructure\MsgAuditCheckAgree;
	use dovechen\yii2\weWork\src\dataStructure\Tag;
	use dovechen\yii2\weWork\src\dataStructure\User;
	use dovechen\yii2\weWork\src\dataStructure\UserInfoByCode;
	use dovechen\yii2\weWork\components\HttpUtils;
	use dovechen\yii2\weWork\components\Utils;
	use yii\base\Event;
	use yii\base\InvalidParamException;

	class Work extends BaseWork
	{
		/**
		 * 每个企业都拥有唯一的corpid，获取此信息可在管理后台“我的企业”－“企业信息”下查看“企业ID”（需要有管理员权限）
		 * @var string
		 */
		public $corpid;
		/**
		 * secret是企业应用里面用于保障数据安全的“钥匙”，每一个应用都有一个独立的访问密钥，为了保证数据的安全，secret务必不能泄漏。
		 * 自建应用secret。在管理后台->“应用与小程序”->“应用”->“自建”，点进某个应用，即可看到。
		 * 基础应用secret。某些基础应用（如“审批”“打卡”应用），支持通过API进行操作。在管理后台->“应用与小程序”->“应用->”“基础”，点进某个应用，点开“API”小按钮，即可看到。
		 * 通讯录管理secret。在“管理工具”-“通讯录同步”里面查看（需开启“API接口同步”）；
		 * 外部联系人管理secret。在“客户联系”栏，点开“API”小按钮，即可看到。
		 * @var string
		 */
		public $secret;
		/**
		 * access_token是企业后台去企业微信的后台获取信息时的重要票据，由corpid和secret产生。所有接口在通信时都需要携带此信息用于验证接口的访问权限
		 * @var string
		 */
		public $access_token;
		/**
		 * 凭证的有效时间（秒）
		 * @var string
		 */
		public $access_token_expire;
		/**
		 * 用于计算签名，由英文或数字组成且长度不超过32位的自定义字符串。
		 * @var string
		 */
		protected $token;
		/**
		 * 用于消息内容加密，由英文或数字组成且长度为43位的自定义字符串。
		 * @var string
		 */
		protected $encodingAesKey;

		/**
		 * 数据缓存前缀
		 * @var string
		 */
		protected $cachePrefix = 'cache_work_wx';

		/**
		 * 企业进行自定义开发调用, 请传参 corpid + secret, 不用关心accesstoken，本类会自动获取并刷新
		 *
		 * @throws \ParameterError
		 */
		public function init ()
		{
			Utils::checkNotEmptyStr($this->corpid, 'corpid');
			Utils::checkNotEmptyStr($this->secret, 'secret');
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
			return $this->cachePrefix . '_' . $this->corpid . '_' . $name;
		}

		/**
		 * 获取 accesstoken 不用主动调用
		 *
		 * @param bool $force
		 *
		 * @return string|void
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public function GetAccessToken ($force = false)
		{
			$time = time();
			if (!Utils::notEmptyStr($this->access_token) || $this->access_token_expire < $time || $force) {
				$result = !Utils::notEmptyStr($this->access_token) && !$force ? $this->getCache("access_token", false) : false;
				if ($result === false) {
					$result = $this->RefreshAccessToken();
				} else {
					if ($result['expire'] < $time) {
						$result = $this->RefreshAccessToken();
					}
				}

				$this->SetAccessToken($result);
			}

			return $this->access_token;
		}

		/**
		 * 更新 accesstoken
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		protected function RefreshAccessToken ()
		{
			if (!Utils::notEmptyStr($this->corpid) || !Utils::notEmptyStr($this->secret)) {
				throw new \ParameterError("invalid corpid or secret");
			}

			$time = time();
			$this->_HttpCall(self::GET_TOKEN, 'GET', ['corpid' => $this->corpid, 'corpsecret' => $this->secret]);

			$this->repJson['expire'] = $time + $this->repJson["expires_in"];
			$this->setCache('access_token', $this->repJson, $this->repJson['expires_in']);

			return $this->repJson;
		}

		/**
		 * 设置 accesstoken
		 *
		 * @param array $accessToken
		 *
		 * @throws InvalidParamException
		 */
		public function SetAccessToken (array $accessToken)
		{
			if (!isset($accessToken['access_token'])) {
				throw new InvalidParamException('The work access_token must be set.');
			} elseif (!isset($accessToken['expire'])) {
				throw new InvalidParamException('Work access_token expire time must be set.');
			}
			$this->access_token        = $accessToken['access_token'];
			$this->access_token_expire = $accessToken['expire'];
		}

		protected function GetOauth2Url ($appid, $redirectUri, $state, $scope = self::SNSAPI_BASE)
		{
			return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
		}

		/* 成员管理 */
		/**
		 * 创建成员
		 *
		 * @link https://work.weixin.qq.com/api/doc/90000/90135/90195
		 *
		 * @param User $user
		 *
		 * @return array|null
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public function userCreate (User $user)
		{
			User::CheckUserCreateArgs($user);
			$args = Utils::Object2Array($user);

			self::_HttpCall(self::USER_CREATE, 'POST', $args);

			return $this->repJson;
		}

		/**
		 * 读取成员
		 *
		 * @link https://work.weixin.qq.com/api/doc/90000/90135/90196
		 *
		 * @param string $userId
		 *
		 * @return User
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public function userGet ($userId)
		{
			Utils::checkNotEmptyStr($userId, 'userid');
			self::_HttpCall(self::USER_GET, 'GET', ['userid' => $userId]);

			return User::parseFromArray($this->repJson);
		}

		/**
		 * 更新成员
		 *
		 * @link https://work.weixin.qq.com/api/doc/90000/90135/90197
		 *
		 * @param User $user
		 *
		 * @return array|null
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public function userUpdata (User $user)
		{
			User::CheckUserUpdateArgs($user);
			$args = Utils::Object2Array($user);
			self::_HttpCall(self::USER_UPDATE, 'POST', $args);

			return $this->repJson;
		}

		/**
		 * 删除成员
		 *
		 * @link https://work.weixin.qq.com/api/doc/90000/90135/90198
		 *
		 * @param string $userId
		 *
		 * @return array|null
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public function userDelete ($userId)
		{
			Utils::checkNotEmptyStr($userId, 'userid');
			self::_HttpCall(self::USER_DELETE, 'GET', ['userid' => $userId]);

			return $this->repJson;

		}

		public function userBatchDelete (array $userIdList)
		{
			User::CheckUserBatchDeleteArgs($userIdList);
			self::_HttpCall(self::USER_BATCH_DELETE, 'POST', ['useridlist' => $userIdList]);

			return $this->repJson;
		}

		public function userSimpleList ($deparmentId, $fetchChild = 0)
		{
			self::_HttpCall(self::USER_SIMPLE_LIST, 'GET', ['department_id' => $deparmentId, 'fetch_child' => $fetchChild]);

			return User::Array2UserList($this->repJson);
		}

		public function userList ($deparmentId, $fetchChild = 0)
		{
			self::_HttpCall(self::USER_LIST, 'GET', ['department_id' => $deparmentId, 'fetch_child' => $fetchChild]);

			return User::Array2UserList($this->repJson);
		}

		public function userConvertToOpenid ($userId, &$openid)
		{
			Utils::checkNotEmptyStr($userId, 'userid');
			self::_HttpCall(self::USER_CONVERT_TO_OPENID, 'POST', ['userid' => $userId]);

			$openid = Utils::arrayGet($this->repJson, 'openid');
		}

		public function userConvertTouserId ($openid, &$userId)
		{
			Utils::checkNotEmptyStr($openid, 'openid');
			self::_HttpCall(self::USER_CONVERT_TO_USERID, 'POST', ['openid' => $openid]);

			$userId = Utils::arrayGet($this->repJson, 'userid');
		}

		public function externalConvertToOpenid ($externalUserid, &$openid)
		{
			Utils::checkNotEmptyStr($externalUserid, 'external_userid');
			self::_HttpCall(self::EXTERNAL_CONTACT_CONVER_TO_OPENID, 'POST', ['external_userid' => $externalUserid]);

			$openid = Utils::arrayGet($this->repJson, 'openid');
		}

		public function userAuthSuccess ($userId)
		{
			Utils::checkNotEmptyStr($userId, 'userid');
			self::_HttpCall(self::USER_AUTHSUCC, 'GET', ['userid' => $userId]);

			return $this->repJson;
		}

		private function getInvalidList (&$invalidUserIdList, &$invalidPartyIdList, &$invalidTagIdList)
		{
			$invalidUserIdList = Utils::arrayGet($this->repJson, "invaliduser");
			if (strpos($invalidUserIdList, '|') !== false) {
				$invalidUserIdList = explode('|', $invalidUserIdList);
			}

			$invalidPartyIdList = Utils::arrayGet($this->repJson, "invalidparty");
			if (strpos($invalidPartyIdList, '|') !== false) {
				$invalidPartyIdList = explode('|', $invalidPartyIdList);
			}

			$invalidTagIdList = Utils::arrayGet($this->repJson, "invalidtag");
			if (strpos($invalidTagIdList, '|') !== false) {
				$invalidTagIdList = explode('|', $invalidTagIdList);
			}
		}

		public function batchInvite ($userIdList = NULL, $partyIdList = NULL, $tagIdList = NULL, &$invalidUserIdList, &$invalidPartyIdList, &$invalidTagIdList)
		{
			if (!Utils::notEmptyArray($userIdList) && !Utils::notEmptyArray($partyIdList) && !Utils::notEmptyArray($tagIdList)) {
				throw new \QyApiError('input can not be all null');
			}

			$args = [];

			if (Utils::notEmptyArray($userIdList)) {
				$args['user'] = $userIdList;
			}

			if (Utils::notEmptyArray($partyIdList)) {
				$args['party'] = $partyIdList;
			}

			if (Utils::notEmptyArray($tagIdList)) {
				$args['tag'] = $tagIdList;
			}

			self::_HttpCall(self::BATCH_INVITE, 'POST', $args);

			$this->getInvalidList($invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
		}

		public function corpGetJoinQrcode (&$joinQrcode, $sizeType = NULL)
		{
			$args = [];
			if (!is_null($sizeType)) {
				$args['size_type'] = $sizeType;
			}

			self::_HttpCall(self::CORP_GET_JOIN_QECODE, 'GET', $args);

			$joinQrcode = Utils::arrayGet($this->repJson, 'join_qrcode');
		}

		/* 部门管理 */
		public function departmentCreate (Department $department, &$departmentId)
		{
			Department::CheckDepartmentCreateArgs($department);
			$args = Department::department2Array($department);
			self::_HttpCall(self::DEPARTMENT_CREATE, 'POST', $args);

			$departmentId = Utils::arrayGet($this->repJson, 'id');
		}

		public function departmentUpdate (Department $department)
		{
			Department::CheckDepartmentUpdateArgs($department);
			$args = Department::department2Array($department);
			self::_HttpCall(self::DEPARTMENT_UPDATE, 'POST', $args);

			return $this->repJson;
		}

		public function departmentDelete ($departmentId)
		{
			Utils::checkIsUInt($departmentId, 'departmentid');
			self::_HttpCall(self::DEPARTMENT_DELETE, 'GET', ['id' => $departmentId]);

			return $this->repJson;
		}

		public function departmentList ($departmentId = NULL)
		{
			$args = [];
			if (!is_null($departmentId)) {
				$args['id'] = $departmentId;
			}
			self::_HttpCall(self::DEPARTMENT_LIST, 'GET', $args);

			return Department::Array2DepartmentList($this->repJson);
		}

		/* 标签管理 */
		public function tagCreate (Tag $tag, &$tagId)
		{
			Tag::CheckTagCreateArgs($tag);
			$args = Tag::Tag2Array($tag);
			self::_HttpCall(self::TAG_CREATE, 'POST', $args);

			$tagId = Utils::arrayGet($this->repJson, 'tagid');
		}

		public function tagUpdate (Tag $tag)
		{
			Tag::CheckTagUpdateArgs($tag);
			$args = Tag::Tag2Array($tag);
			self::_HttpCall(self::TAG_UPDATE, 'POST', $args);

			return $this->repJson;
		}

		public function tagDelete ($tagId)
		{
			Utils::checkIsUInt($tagId, 'tagid');
			self::_HttpCall(self::TAG_DELETE, 'GET', ['tagid' => $tagId]);

			return $this->repJson;
		}

		public function tagGet ($tagId)
		{
			Utils::checkIsUInt($tagId, 'tagid');
			self::_HttpCall(self::TAG_GET, 'GET', ['tagid' => $tagId]);

			return Tag::parseFromArray($this->repJson);
		}

		public function tagAddTagUsers ($tagId, $userIdList = [], $partyIdList = [])
		{
			Tag::CheckTagADUserArgs($tagId, $userIdList, $partyIdList);

			$args = Tag::ToTagADUserArray($tagId, $userIdList, $partyIdList);

			self::_HttpCall(self::TAG_ADD_TAG_USERS, 'POST', $args);

			return $this->repJson;
		}

		public function tagDelTagUsers ($tagId, $userIdList = [], $partyIdList = [])
		{
			Tag::CheckTagADUserArgs($tagId, $userIdList, $partyIdList);

			$args = Tag::ToTagADUserArray($tagId, $userIdList, $partyIdList);

			self::_HttpCall(self::TAG_DEL_TAG_USERS, 'POST', $args);

			return $this->repJson;
		}

		public function tagList ()
		{
			self::_HttpCall(self::TAG_LIST);

			return Tag::Array2TagList($this->repJson);
		}

		/* 异步批量接口 */
		private function batchJob (BatchJobArgs $batchJobArgs, $jobType)
		{
			Batch::CheckBatchJobArgs($batchJobArgs);
			$args = Utils::Object2Array($batchJobArgs);
			$url  = '';
			switch ($jobType) {
				case 'syncsuser':
					$url = self::BATCH_SYNC_USER;

					break;
				case 'replaceuser':
					$url = self::BATCH_REPLACE_USER;

					break;
				case 'replaceparty':
					$url = self::BATCH_REPLACE_PARTY;

					break;
				default:
					break;
			}

			if (!Utils::notEmptyStr($url)) {
				throw new \QyApiError('job type not invlide.');
			}

			self::_HttpCall($url, 'POST');

			return Utils::arrayGet($this->repJson, 'jobid');
		}

		public function batchSyncUser (BatchJobArgs $batchJobArgs)
		{
			return self::batchJob($batchJobArgs, 'syncuser');
		}

		public function batchReplaceUser (BatchJobArgs $batchJobArgs)
		{
			return self::batchJob($batchJobArgs, 'replaceuser');
		}

		public function batchReplaceParty (BatchJobArgs $batchJobArgs)
		{
			return self::batchJob($batchJobArgs, 'replaceparty');
		}

		public function batchGetResult ($jobId)
		{
			Utils::checkNotEmptyStr($jobId, 'jobid');
			self::_HttpCall(self::BATCH_GET_RESULT, 'GET', ['jobid' => $jobId]);

			return Batch::parseFromArray($this->repJson);
		}

		/* 企业服务人员管理 */
		public function ECGetFollowUserList ()
		{
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_FOLLOW_USER_LIST);

			return $this->repJson;
		}

		public function ECAddContactWay (ExternalContactWay $externalContactWay)
		{
			ExternalContactWay::CheckExternalContactWayAddArgs($externalContactWay);
			$args = Utils::Object2EmptyArray($externalContactWay);
			self::_HttpCall(self::EXTERNAL_CONTACT_ADD_CONTACT_WAY, 'POST', $args);

			return $this->repJson;
		}

		public function ECGetContactWay ($configId)
		{
			Utils::checkNotEmptyStr($configId, 'config_id');
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_CONTACT_WAY, 'POST', ['config_id' => $configId]);

			return ExternalContact::wayParseFromArray($this->repJson);
		}

		public function ECUpdateContactWay (ExternalContactWay $externalContactWay)
		{
			ExternalContactWay::CheckExternalContactWayUpdateArgs($externalContactWay);
			$args = Utils::Object2EmptyArray($externalContactWay);
			self::_HttpCall(self::EXTERNAL_CONTACT_UPDATE_CONTACT_WAY, 'POST', $args);

			return $this->repJson;
		}

		public function ECDelContactWay ($configId)
		{
			Utils::checkNotEmptyStr($configId, 'config_id');
			self::_HttpCall(self::EXTERNAL_CONTACT_DEL_CONTACT_WAY, 'POST', ['config_id' => $configId]);

			return $this->repJson;
		}

		/* 客户管理 */
		public function ECList ($userId)
		{
			Utils::checkNotEmptyStr($userId, 'userid');
			self::_HttpCall(self::EXTERNAL_CONTACT_LIST, 'GET', ['userid' => $userId]);

			return $this->repJson;
		}

		public function ECGet ($externalUserId)
		{
			Utils::checkNotEmptyStr($externalUserId, 'external userid');
			self::_HttpCall(self::EXTERNAL_CONTACT_GET, 'GET', ['external_userid' => $externalUserId]);

			$externalContact                = Utils::arrayGet($this->repJson, 'external_contact');
			$externalContact['follow_user'] = Utils::arrayGet($this->repJson, 'follow_user');

			return ExternalContact::parseFromArray($externalContact);
		}

		public function ECBatchGetByUser (ExternalContactBatchGetByUser $batchGetByUser)
		{
			ExternalContactBatchGetByUser::CheckExternalContactBatchGetByUserArgs($batchGetByUser);
			$args = Utils::Object2EmptyArray($batchGetByUser);
			self::_HttpCall(self::EXTERNAL_CONTACT_BATCH_GET_BY_USER, 'POST', $args);

			$externalContactListInfo = [
				'external_contact_list' => Utils::arrayGet($this->repJson, 'external_contact_list'),
				'next_cursor'           => Utils::arrayGet($this->repJson, 'next_cursor')
			];

			return $externalContactListInfo;
		}

		public function ECRemark (ExternalContactRemark $externalContactRemark)
		{
			ExternalContactRemark::CheckExternalContactRmarkArgs($externalContactRemark);
			$args = Utils::Object2EmptyArray($externalContactRemark);
			self::_HttpCall(self::EXTERNAL_CONTACT_REMARK, 'POST', $args);

			return $this->repJson;
		}

		/* 客户标签管理 */
		public function ECGetCorpTagList ($tagIdList = NULL)
		{
			$args = [];
			if (!is_null($tagIdList)) {
				Utils::checkNotEmptyArray($tagIdList, 'tag id list');
				$args['tag_id'] = $tagIdList;
			}

			self::_HttpCall(self::EXTERNAL_CONTACT_GET_CORP_TAG_LIST, 'POST', $args);

			return ExternalContactTagGroup::arrayToTagGroup($this->repJson);
		}

		public function ECAddCorpTag (ExternalContactTagGroup $tagGroup)
		{
			ExternalContactTagGroup::checkExternalContactTagGroupAddArgs($tagGroup);
			$args = Utils::Object2Array($tagGroup);
			self::_HttpCall(self::EXTERNAL_CONTACT_ADD_CORP_TAG, 'POST', $args);

			return ExternalContactTagGroup::parseFromArray(Utils::arrayGet($this->repJson, 'tag_group'));
		}

		public function ECEditCorpTag (ExternalContactTag $tag)
		{
			ExternalContactTag::checkExternalContactTagEditArgs($tag);
			$args = Utils::Object2Array($tag);
			self::_HttpCall(self::EXTERNAL_CONTACT_EDIT_CORP_TAG, 'POST', $args);

			return $this->repJson;
		}

		public function ECDelCorpTag ($tagIdList = [], $groupIdList = [])
		{
			if (!Utils::notEmptyArray($tagIdList) && !Utils::notEmptyArray($groupIdList)) {
				throw new \QyApiError('input error paramter.');
			}

			$args = [];
			if (Utils::notEmptyArray($tagIdList)) {
				$args['tag_id'] = $tagIdList;
			}
			if (Utils::notEmptyArray($groupIdList)) {
				$args['group_id'] = $groupIdList;
			}

			self::_HttpCall(self::EXTERNAL_CONTACT_DEL_CORP_TAG, 'POST', $args);

			return $this->repJson;
		}

		public function ECMarkTag ($userId, $externalUserId, $addTagList = [], $removeTagList = [])
		{
			Utils::checkNotEmptyStr($userId, 'user id');
			Utils::checkNotEmptyStr($externalUserId, 'external user id');

			if (!Utils::notEmptyArray($addTagList) && !Utils::notEmptyArray($removeTagList)) {
				throw new \QyApiError('input error paramter.');
			}

			$args = [
				'userid'          => $userId,
				'external_userid' => $externalUserId
			];
			if (Utils::notEmptyArray($addTagList)) {
				$args['add_tag'] = $addTagList;
			}
			if (Utils::notEmptyArray($removeTagList)) {
				$args['remove_tag'] = $removeTagList;
			}

			self::_HttpCall(self::EXTERNAL_CONTACT_MARK_TAG, 'POST', $args);

			return $this->repJson;
		}

		// TODO: 还需要优化
		public function ECGroupChatList ($offset = 0, $limit = 100, $statusFilter = 0, $ownerFilter = [])
		{
			$args = [
				'status_filter' => $statusFilter,
				'offset'        => $offset,
				'limit'         => $limit,
			];
			if (Utils::notEmptyArray($ownerFilter)) {
				$args['owner_filter'] = $ownerFilter;
			}

			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_CHAT_LIST, 'POST', $args);

			return $this->repJson;
		}

		public function ECGroupChatGet ($chatId)
		{
			Utils::checkNotEmptyStr($chatId, 'chat_id');
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_CHAT_GET, 'POST', ['chat_id' => $chatId]);

			return ExternalContactGroupChat::parseFromArray(Utils::arrayGet($this->repJson, 'group_chat'));
		}

		public function ECAddMsgTemplate (ExternalContactMsgTemplate $msgTemplate)
		{
			ExternalContactMsgTemplate::checkMsgTemplateAddArgs($msgTemplate);
			$args = Utils::Object2Array($msgTemplate);
			self::_HttpCall(self::EXTERNAL_CONTACT_ADD_MSG_TEMPLATE, "POST", $args);

			return $this->repJson;
		}

		public function ECGetGroupMsgResult ($msgId)
		{
			Utils::checkNotEmptyStr($msgId, 'msgid');
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_GROUP_MSG_RESULT, 'POST', ['msgid' => $msgId]);

			return $this->repJson;
		}

		public function ECSendWelcomeMsg (ExternalContactMsgTemplate $msgTemplate)
		{
			ExternalContactMsgTemplate::checkMsgTemplateSendArgs($msgTemplate);
			$args = Utils::Object2Array($msgTemplate);
			self::_HttpCall(self::EXTERNAL_CONTACT_SEND_WELCOME_MSG, "POST", $args);

			return $this->repJson;
		}

		public function ECGroupWelcomeTemplateAdd (ExternalContactMsgTemplate $msgTemplate)
		{
			ExternalContactMsgTemplate::checkGroupWelcomeTemplateAddArgs($msgTemplate);
			$args = Utils::Object2Array($msgTemplate);
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_ADD, "POST", $args);

			return $this->repJson;
		}

		public function ECGroupWelcomeTemplateEdit (ExternalContactMsgTemplate $msgTemplate)
		{
			ExternalContactMsgTemplate::checkGroupWelcomeTemplateEditArgs($msgTemplate);
			$args = Utils::Object2Array($msgTemplate);
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_EDIT, "POST", $args);

			return $this->repJson;
		}

		public function ECGroupWelcomeTemplateGet ($templateId)
		{
			Utils::checkNotEmptyStr($templateId, 'template_id');
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_GET, "POST", ['template_id' => $templateId]);

			return ExternalContactMsgTemplate::parseFromArray($this->repJson);
		}

		public function ECGroupWelcomeTemplateDel ($templateId)
		{
			Utils::checkNotEmptyStr($templateId, 'template_id');
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_DEL, "POST", ['template_id' => $templateId]);

			return $this->repJson;
		}

		public function ECGetUnAssignedList ($pageId = 0, $pageSize = 1000)
		{
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_UNASSIGNED_LIST, 'POST', ['page_id' => $pageId, 'page_size' => $pageSize]);

			return ExternalContactUnAssignUser::arrayToUnAssignUserInfo($this->repJson);
		}

		public function ECTransfer ($externalUserId, $handoverUserId, $takeoverUserId)
		{
			Utils::checkNotEmptyStr($externalUserId, 'external_userid');
			Utils::checkNotEmptyStr($handoverUserId, 'handover_userid');
			Utils::checkNotEmptyStr($takeoverUserId, 'takeover_userid');

			$args = [
				'external_userid' => $externalUserId,
				'handover_userid' => $handoverUserId,
				'takeover_userid' => $takeoverUserId,
			];
			self::_HttpCall(self::EXTERNAL_CONTACT_TRANSFER, 'POST', $args);

			return $this->repJson;
		}

		public function ECGroupChatTransfer ($chadIdList, $newOwner)
		{
			Utils::checkNotEmptyArray($chadIdList, 'chat_id_list');
			Utils::checkNotEmptyStr($newOwner, 'new_owner');

			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_CHAT_TRANSFER, 'POST', ['chat_id_list' => $chadIdList, 'new_owner' => $newOwner]);

			return $this->repJson;
		}

		public function EContactGetTransferResult ($handoverData)
		{
			$args = Utils::Object2Array($handoverData);
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_TRANSFER_RESULT, 'POST', $args);

			return $this->repJson;
		}

		public function ECGetUserBeheviorData ($behavior)
		{
			ExternalContactBehavior::checkBehaviorGetArgs($behavior);
			self::_HttpCall(self::EXTERNAL_CONTACT_GET_USER_BEHAVIOR_DATA, 'POST', $behavior);

			return ExternalContactBehavior::arrayToBehaviorData($this->repJson);
		}

		public function ECGroupChatStatistic ($filter)
		{
			ExternalContactGroupChat::checkGroupChatStatisticArgs($filter);
			self::_HttpCall(self::EXTERNAL_CONTACT_GROUP_CHAT_STATISTIC, 'POST', $filter);

			return $this->repJson;
		}

		public function GetUserInfoByCode ($code)
		{
			Utils::checkNotEmptyStr($code, "code");
			self::_HttpCall(self::USR_GET_USER_INFO, 'GET', ['code' => $code]);

			return UserInfoByCode::parseFromArray($this->repJson);
		}

		/* 素材管理 */
		public function MediaUpload ($filePath, $type, $plus = [])
		{
			Utils::checkNotEmptyStr($filePath, "filePath");
			Utils::checkNotEmptyStr($type, "type");
			if (!file_exists($filePath)) {
				throw new \QyApiError("file not exists");
			}
			$fileName = !empty($plus['file_name']) ? $plus['file_name'] : basename($filePath);
			// 兼容php5.3-5.6 curl模块的上传操作
			$args = [];
			if (class_exists('\CURLFile')) {
				$args = ['media' => new \CURLFile(realpath($filePath), 'application/octet-stream', $fileName)];
			} else {
				$args = ['media' => '@' . realpath($filePath)];
			}

			self::_HttpCall(self::MEDIA_UPLOAD . '&type=' . $type, 'POST', $args, true, true);

			return $this->repJson["media_id"];
		}

		public function MediaUploadByBuffer ($buffer, $type)
		{
			$tmpPath = self::WriteTmpFile($buffer);

			try {
				$ret = $this->mediaUpload($tmpPath, $type);
				unlink($tmpPath);

				return $ret;
			} catch (Exception $ex) {
				unlink($tmpPath);
				throw $ex;
			}
		}

		public function MediaGet ($media_id)
		{
			Utils::checkNotEmptyStr($media_id, "media_id");
			self::_HttpCall(self::MEDIA_GET, 'GET', ['media_id' => $media_id]);

			return $this->repRawStr;
		}

		public function UploadImage ($filePath, $md5 = NULL)
		{
			Utils::checkNotEmptyStr($filePath, "filePath");
			if (!file_exists($filePath)) {
				throw new \QyApiError("file not exists");
			}

			// 兼容php5.3-5.6 curl模块的上传操作
			$args = [];
			if (class_exists('\CURLFile')) {
				$args = ['media' => new \CURLFile(realpath($filePath), 'application/octet-stream', basename($filePath))];
			} else {
				$args = ['media' => '@' . $filePath];//realpath($filePath));
			}

			self::_HttpCall(self::MEDIA_UPLOAD_IMG, 'POST', $args, true, true);

			return $this->repJson["url"];
		}

		/* 发送应用消息 */
		public function MessageSend (Message $message, &$invalidUserIdList, &$invalidPartyIdList, &$invalidTagIdList)
		{
			Message::CheckMessageSendArgs($message);
			$args = Message::Message2Array($message);

			self::_HttpCall(self::MESSAGE_SEND, 'POST', $args);

			$this->getInvalidList($invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);

			return $this->repJson;
		}

		/* 互联企业消息推送 */
		public function LinkedMessageSend (LinkedcorpMessage $message, &$invalidUserIdList, &$invalidPartyIdList, &$invalidTagIdList)
		{
			LinkedcorpMessage::CheckMessageSendArgs($message);
			$args = LinkedcorpMessage::Message2Array($message);

			self::_HttpCall(self::LINKED_CORP_MESSAGE_SEND, 'POST', $args);

			$this->getInvalidList($invalidUserIdList, $invalidPartyIdList, $invalidTagIdList);
		}

		public function GetJsapiTicket ()
		{
			self::_HttpCall(self::GET_JSAPI_TICKET);

			return $this->repJson;
		}

		public function TicketGet ()
		{
			self::_HttpCall(self::TICKET_GET, 'GET', ['type' => 'agent_config']);

			return $this->repJson;
		}

		public function JsApiSignatureGet ($jsapiTicket, $nonceStr, $timestamp, $url)
		{
			$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

			return sha1($string);
		}

		public function AgentGet ($agentId)
		{
			self::_HttpCall(self::AGENT_GET, 'GET', ['agentid' => $agentId]);

			return $this->repJson;
		}

		public function AgentSet (Agent $agent)
		{
			Agent::CheckAgentSetArgs($agent);
			$args = Agent::AgentSetArgs($agent);
			self::_HttpCall(self::AGENT_SET, 'POST', $args);

			return $this->repJson;
		}

		public function AgentList ()
		{
			self::_HttpCall(self::AGENT_LIST);

			return $this->repJson;
		}

		public function GetPermitUserList ()
		{
			self::_HttpCall(self::GET_PERMIT_USER_LIST);

			return $this->repJson;
		}

		public function CheckSingleAgree (MsgAuditCheckAgree $msgAuditCheck)
		{
			MsgAuditCheckAgree::CheckSingleAgreeArgs($msgAuditCheck);
			$args = MsgAuditCheckAgree::SetSingleAgreeArgs($msgAuditCheck);
			self::_HttpCall(self::CHECK_SINGLE_AGREE, 'POST', $args);

			return $this->repJson;
		}

		public function CheckRoomAgree (MsgAuditCheckAgree $msgAuditCheck)
		{
			MsgAuditCheckAgree::CheckRoomAgreeArgs($msgAuditCheck);
			$args = MsgAuditCheckAgree::SetRoomAgreeArgs($msgAuditCheck);
			self::_HttpCall(self::CHECK_ROOM_AGREE, 'POST', $args);

			return $this->repJson;
		}

		public function GroupChatGet ($roomId)
		{

			Utils::checkNotEmptyStr($roomId, 'roomid');
			self::_HttpCall(self::GROUP_CHAT_GET, 'POST', ['roomid' => $roomId]);

			return $this->repJson;
		}

		public function GetMomentList ($startTime, $endTime, $creator = '', $filterType = 2, $cursor = '', $limit = 100)
		{
			Utils::checkNotEmptyStr($startTime, 'start_time');
			Utils::checkNotEmptyStr($endTime, 'end_time');
			if ($limit < 1 || $limit > 100) {
				throw new \ParameterError('limit must be inter and lt 100');
			}
			$args = [
				'start_time'  => $startTime,
				'end_time'    => $endTime,
				'filter_type' => $filterType,
				'cursor'      => $cursor,
				'limit'       => $limit,
			];

			if (!empty($creator)) {
				$args['creator'] = $creator;
			}

			self::_HttpCall(self::GET_MOMENT_LIST, 'POST', $args);

			return $this->repJson;
		}

		public function GetMomentTask ($momentId, $cursor = '', $limit = 500)
		{
			Utils::checkNotEmptyStr($momentId, 'moment_id');
			if ($limit < 1 || $limit > 1000) {
				throw new \ParameterError('limit must be inter and lt 1000');
			}
			$args = [
				'moment_id' => $momentId,
				'cursor'    => $cursor,
				'limit'     => $limit,
			];
			self::_HttpCall(self::GET_MOMENT_TASK, 'POST', $args);

			return $this->repJson;
		}

		public function GetMomentCustomerList ($momentId, $userId, $cursor = '', $limit = 500)
		{
			Utils::checkNotEmptyStr($momentId, 'moment_id');
			Utils::checkNotEmptyStr($userId, 'user_id');
			if ($limit < 1 || $limit > 1000) {
				throw new \ParameterError('limit must be inter and lt 1000');
			}
			$args = [
				'moment_id' => $momentId,
				'userid'    => $userId,
				'cursor'    => $cursor,
				'limit'     => $limit,
			];
			self::_HttpCall(self::GET_MOMENT_CUSTOMER_LIST, 'POST', $args);

			return $this->repJson;
		}

		public function GetMomentSendResult ($momentId, $userId, $cursor = '', $limit = 3000)
		{
			Utils::checkNotEmptyStr($momentId, 'moment_id');
			Utils::checkNotEmptyStr($userId, 'user_id');
			if ($limit < 1 || $limit > 5000) {
				throw new \ParameterError('limit must be inter and lt 5000');
			}
			$args = [
				'moment_id' => $momentId,
				'userid'    => $userId,
				'cursor'    => $cursor,
				'limit'     => $limit,
			];
			self::_HttpCall(self::GET_MOMENT_SEND_RESULT, 'POST', $args);

			return $this->repJson;
		}

		public function GetMomentComments ($momentId, $userId)
		{
			Utils::checkNotEmptyStr($momentId, 'moment_id');
			Utils::checkNotEmptyStr($userId, 'user_id');
			$args = [
				'moment_id' => $momentId,
				'userid'    => $userId,
			];
			self::_HttpCall(self::GET_MOMENT_COMMENTS, 'POST', $args);

			return $this->repJson;
		}
	}