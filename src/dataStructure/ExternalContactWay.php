<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class ExternalContactWay
	 *
	 * @property string  $config_id      新增联系方式的配置id
	 * @property int     $type           联系方式类型,1-单人, 2-多人
	 * @property int     $scene          场景，1-在小程序中联系，2-通过二维码联系
	 * @property int     $style          在小程序中联系时使用的控件样式，详见附表
	 * @property string  $remark         联系方式的备注信息，用于助记，不超过30个字符
	 * @property boolean $skip_verify    外部客户添加时是否无需验证，默认为true
	 * @property string  $state          企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
	 * @property array   $user           使用该联系方式的用户userID列表，在type为1时为必填，且只能有一个
	 * @property array   $party          使用该联系方式的部门id列表，只在type为2时有效
	 * @property string  $qr_code        联系二维码的URL，仅在scene为2时返回
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class ExternalContactWay
	{
		const TYPE_ONLY = 1;
		const TYPE_MORE = 2;

		const MINIPROGRAM_SCENE = 1;
		const QRCODE_SCENE = 2;

		/**
		 * @param $arr
		 *
		 * @return ExternalContactWay
		 */
		public static function parseFromArray ($arr)
		{
			$externalContactWay = new ExternalContactWay();

			$externalContactWay->config_id   = Utils::arrayGet($arr, 'config_id');
			$externalContactWay->type        = Utils::arrayGet($arr, 'type');
			$externalContactWay->scene       = Utils::arrayGet($arr, 'scene');
			$externalContactWay->style       = Utils::arrayGet($arr, 'style');
			$externalContactWay->remark      = Utils::arrayGet($arr, 'remark');
			$externalContactWay->skip_verify = Utils::arrayGet($arr, 'skip_verify');
			$externalContactWay->state       = Utils::arrayGet($arr, 'state');
			$externalContactWay->qr_code     = Utils::arrayGet($arr, 'qr_code');

			return $externalContactWay;
		}

		/**
		 * @param ExternalContactWay $externalContactWay
		 *
		 * @throws \ParameterError
		 */
		public static function CheckExternalContactWayAddArgs ($externalContactWay)
		{
			Utils::checkIsUInt($externalContactWay->type, 'external contact type');
			Utils::checkIsUInt($externalContactWay->scene, 'external contact scene');

			if ($externalContactWay->type == ExternalContactWay::TYPE_ONLY) {
				Utils::checkNotEmptyArray($externalContactWay->user, 'external contact user');

				if (count($externalContactWay->user) > 1) {
					throw new \ParameterError('user only can be one');
				}
			}

			if ($externalContactWay->type == ExternalContactWay::TYPE_MORE) {
				if (!Utils::notEmptyArray($externalContactWay->user) && !Utils::notEmptyArray($externalContactWay->party)) {
					throw new \ParameterError('error input parameter.');
				}
			}
		}

		/**
		 * @param ExternalContactWay $externalContactWay
		 *
		 * @throws \ParameterError
		 */
		public static function CheckExternalContactWayUpdateArgs ($externalContactWay)
		{
			Utils::checkNotEmptyStr($externalContactWay->config_id, 'external contact config_id');
		}
	}