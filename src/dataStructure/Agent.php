<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/2/24
	 * Time: 11:44
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class Agent
	 *
	 * @property int    $agentid                 企业应用id
	 * @property string $name                    企业应用名称
	 * @property string $square_logo_url         企业应用方形头像
	 * @property string $logo_mediaid            企业应用头像的mediaid，通过素材管理接口上传图片获得mediaid，上传后会自动裁剪成方形和圆形两个头像
	 * @property string $description             企业应用详情
	 * @property array  $allow_userinfos         企业应用可见范围（人员），其中包括userid
	 * @property array  $allow_partys            企业应用可见范围（部门）
	 * @property array  $allow_tags              企业应用可见范围（标签）
	 * @property int    $close                   企业应用是否被停用
	 * @property string $redirect_domain         企业应用可信域名
	 * @property int    $report_location_flag    企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
	 * @property int    $isreportenter           是否上报用户进入应用事件。0：不接收；1：接收
	 * @property string $home_url                应用主页url
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class Agent
	{
		/**
		 * @param $arr
		 *
		 * @return Agent
		 */
		public static function parseFromArray ($arr)
		{
			$agent = new Agent();

			$agent->agentid         = Utils::arrayGet($arr, 'agentid');
			$agent->name            = Utils::arrayGet($arr, 'name');
			$agent->square_logo_url = Utils::arrayGet($arr, 'square_logo_url');
			$agent->logo_mediaid    = Utils::arrayGet($arr, 'logo_mediaid');
			$agent->description     = Utils::arrayGet($arr, 'description');

			$allowUserinfos = Utils::arrayGet($arr, 'allow_userinfos');
			if (!is_null($allowUserinfos)) {
				$users = Utils::arrayGet($allowUserinfos, 'user');
				if (!is_null($users)) {
					$agent->allow_userinfos = [];
					foreach ($users as $user) {
						array_push($agent->allow_userinfos, Utils::arrayGet($user, 'userid'));
					}
				}
			}

			$allowPartys = Utils::arrayGet($arr, 'allow_partys');
			if (!is_null($allowPartys)) {
				$agent->allow_partys = Utils::arrayGet($allowPartys, 'partyid');
			}

			$allowTags = Utils::arrayGet($arr, 'allow_tags');
			if (!is_null($allowTags)) {
				$agent->allow_tags = Utils::arrayGet($allowTags, 'tagid');
			}

			$agent->close                = Utils::arrayGet($arr, 'close');
			$agent->redirect_domain      = Utils::arrayGet($arr, 'redirect_domain');
			$agent->report_location_flag = Utils::arrayGet($arr, 'report_location_flag');
			$agent->isreportenter        = Utils::arrayGet($arr, 'isreportenter');
			$agent->home_url             = Utils::arrayGet($arr, 'home_url');

			return $agent;
		}

		/**
		 * @param $arr
		 *
		 * @return array
		 */
		public static function Array2AgentList ($arr)
		{
			$agentList     = [];
			$agentListData = Utils::arrayGet($arr, 'agentlist');

			if (!is_null($agentListData)) {
				foreach ($agentListData as $agentData) {
					array_push($agentList, static::parseFromArray($agentData));
				}
			}

			return $agentList;
		}

		/**
		 * @param Agent $agent
		 *
		 * @return array
		 */
		public static function AgentSetArgs ($agent)
		{
			$args = [];

			Utils::setIfNotNull($agent->agentid, 'agentid', $args);
			Utils::setIfNotNull($agent->name, 'name', $args);
			Utils::setIfNotNull($agent->logo_mediaid, 'logo_mediaid', $args);
			Utils::setIfNotNull($agent->description, 'description', $args);
			Utils::setIfNotNull($agent->redirect_domain, 'redirect_domain', $args);
			Utils::setIfNotNull($agent->report_location_flag, 'report_location_flag', $args);
			Utils::setIfNotNull($agent->isreportenter, 'isreportenter', $args);
			Utils::setIfNotNull($agent->home_url, 'home_url', $args);

			return $args;
		}

		/**
		 * @param Agent $agent
		 *
		 * @throws \ParameterError
		 */
		public static function CheckAgentSetArgs ($agent)
		{
			Utils::checkIsUInt($agent->agentid, 'agentid');
		}
	}