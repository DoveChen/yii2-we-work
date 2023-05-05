<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactFollowUser
	 *
	 * @property string $userid             添加了此外部联系人的企业成员userid
	 * @property string $remark             该成员对此外部联系人的备注
	 * @property string $description        该成员对此外部联系人的描述
	 * @property string $createtime         该成员添加此外部联系人的时间
	 * @property string $state              该成员添加此客户的渠道，由用户通过创建「联系我」方式指定
	 * @property array  $tags               标签信息
	 * @property string $remark_corp_name   该成员对此客户备注的企业名称
	 * @property array  $remark_mobiles     该成员对此客户备注的手机号码，第三方不可获取
	 * @property array  $add_way            该成员添加此客户的来源0、未知来源；1、 扫描二维码；2、搜索手机号；3、名片分享；4、群聊；5、手机通讯录；6、微信联系人；7、来自微信的添加好友申请；8、安装第三方应用时自动添加的客服人员；9、搜索邮箱；201、内部成员共享；202、管理员/负责人分配
	 * @property array  $wechat_channels    该成员添加此客户的来源add_way为10时，对应的视频号信息
	 * @property array  $oper_userid        发起添加的userid，如果成员主动添加，为成员的userid；如果是客户主动添加，则为客户的外部联系人userid；如果是内部成员共享/管理员分配，则为对应的成员/管理员userid
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactFollowUser
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactFollowUser
		 */
		public static function parseFromArray ($arr)
		{
			$externalContactFollowUser = new ExternalContactFollowUser();

			$externalContactFollowUser->userid      = Utils::arrayGet($arr, 'userid');
			$externalContactFollowUser->remark      = Utils::arrayGet($arr, 'remark');
			$externalContactFollowUser->description = Utils::arrayGet($arr, 'description');
			$externalContactFollowUser->createtime  = Utils::arrayGet($arr, 'createtime');
			$externalContactFollowUser->state       = Utils::arrayGet($arr, 'state');

			$userTags                        = Utils::arrayGet($arr, 'tags');
			$externalContactFollowUser->tags = [];
			if (Utils::notEmptyArray($userTags)) {
				foreach ($userTags as $item) {
					array_push($externalContactFollowUser->tags, ExternalContactFollowUserTag::parseFromArray($item));
				}
			}

			$externalContactFollowUser->remark_corp_name = Utils::arrayGet($arr, 'remark_corp_name');
			$externalContactFollowUser->remark_mobiles   = Utils::arrayGet($arr, 'remark_mobiles');
			$externalContactFollowUser->add_way          = Utils::arrayGet($arr, 'add_way');

			$wechatChannels = Utils::arrayGet($arr, 'wechat_channels');
			if (!is_null($wechatChannels) && !empty($wechatChannels)) {
				$externalContactFollowUser->wechat_channels = [
					'nickname' => Utils::arrayGet($wechatChannels, 'nickname'),
					'source'   => Utils::arrayGet($wechatChannels, 'source'),
				];
			}

			$externalContactFollowUser->oper_userid = Utils::arrayGet($arr, 'oper_userid');

			return $externalContactFollowUser;
		}
	}