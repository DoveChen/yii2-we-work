<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactMsgTemplate
	 *
	 * @property string $welcome_code       通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒
	 * @property string $template_id        欢迎语素材id
	 * @property array  $external_userid    客户的外部联系人id列表，不可与sender同时为空，最多可传入1万个客户
	 * @property string $sender             发送企业群发消息的成员userid，不可与external_userid同时为空
	 * @property array  $text               消息文本
	 * @property array  $image              图片
	 * @property array  $link               图文
	 * @property array  $miniprogram        小程序
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactMsgTemplate
	{
		/**
		 * @param array $arr
		 *
		 * @return ExternalContactMsgTemplate
		 */
		public static function parseFromArray ($arr)
		{
			$template = new ExternalContactMsgTemplate();

			$templateWelcomeCode = Utils::arrayGet($arr, 'welcome_code');
			if (!is_null($templateWelcomeCode)) {
				$template->welcome_code = $templateWelcomeCode;
			}
			
			$templateExternalUserid = Utils::arrayGet($arr, 'external_userid');
			if (!is_null($templateExternalUserid)) {
				$template->external_userid = $templateExternalUserid;
			}

			$templateText = Utils::arrayGet($arr, 'text');
			if (!is_null($templateText)) {
				$template->text = ExternalContactMsgTemplateText::parseFromArray($templateText);
			}

			$templateImg = Utils::arrayGet($arr, 'image');
			if (!is_null($templateImg)) {
				$template->image = ExternalContactMsgTemplateImage::parseFromArray($templateImg);
			}

			$templateLink = Utils::arrayGet($arr, 'link');
			if (!is_null($templateLink)) {
				$template->link = ExternalContactMsgTemplateLink::parseFromArray($templateLink);
			}

			$templateMini = Utils::arrayGet($arr, 'miniprogram');
			if (!is_null($templateMini)) {
				$template->miniprogram = ExternalContactMsgTemplateMiniprogram::parseFromArray($templateMini);
			}

			return $template;
		}

		/**
		 * @param ExternalContactMsgTemplate $msgTemplate
		 *
		 *
		 * @throws \ParameterError
		 */
		public static function checkMsgTemplateAddArgs ($msgTemplate)
		{
			if (!Utils::notEmptyArray($msgTemplate->external_userid) && !Utils::notEmptyArray($msgTemplate->sender)) {
				throw new \ParameterError('input error paramter.');
			}

			/*
			 * text、image、link和miniprogram四者不能同时为空；
			 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
			 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
			 * media_id可以通过素材管理接口获得。
			 */
			if (empty($msgTemplate->text) && empty($msgTemplate->image) && empty($msgTemplate->link) && empty($msgTemplate->miniprogram)) {
				throw new \ParameterError('input error paramter.');
			}
		}

		/**
		 * @param ExternalContactMsgTemplate $msgTemplate
		 *
		 *
		 * @throws \ParameterError
		 */
		public static function checkMsgTemplateSendArgs ($msgTemplate)
		{
			Utils::checkNotEmptyStr($msgTemplate->welcome_code, 'welcome code');

			/*
			 * text、image、link和miniprogram四者不能同时为空；
			 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
			 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
			 * media_id可以通过素材管理接口获得。
			 */
			if (empty($msgTemplate->text) && empty($msgTemplate->image) && empty($msgTemplate->link) && empty($msgTemplate->miniprogram)) {
				throw new \ParameterError('input error paramter.');
			}
		}

		/**
		 * @param ExternalContactMsgTemplate $msgTemplate
		 *
		 *
		 * @throws \ParameterError
		 */
		public static function checkGroupWelcomeTemplateAddArgs ($msgTemplate)
		{
			/*
			 * text、image、link和miniprogram四者不能同时为空；
			 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
			 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
			 * media_id可以通过素材管理接口获得。
			 */
			if (empty($msgTemplate->text) && empty($msgTemplate->image) && empty($msgTemplate->link) && empty($msgTemplate->miniprogram)) {
				throw new \ParameterError('input error paramter.');
			}
		}

		/**
		 * @param ExternalContactMsgTemplate $msgTemplate
		 *
		 *
		 * @throws \ParameterError
		 */
		public static function checkGroupWelcomeTemplateEditArgs ($msgTemplate)
		{
			Utils::checkNotEmptyStr($msgTemplate->template_id, 'template id');

			/*
			 * text、image、link和miniprogram四者不能同时为空；
			 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
			 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
			 * media_id可以通过素材管理接口获得。
			 */
			if (empty($msgTemplate->text) && empty($msgTemplate->image) && empty($msgTemplate->link) && empty($msgTemplate->miniprogram)) {
				throw new \ParameterError('input error paramter.');
			}
		}
	}