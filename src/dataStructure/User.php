<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	include_once "../../components/errorInc/error.inc.php";

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class User
	 *
	 * @property string     userid              成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节。只能由数字、字母和“_-@.”四种字符组成，且第一个字符必须是数字或字母。
	 * @property string     name                成员名称。长度为1~64个utf8字符
	 * @property string     alias               成员别名。长度1~32个utf8字符
	 * @property string     mobile              手机号码。企业内必须唯一，mobile/email二者不能同时为空
	 * @property array      department          成员所属部门id列表,不超过20个
	 * @property array      order               部门内的排序值，默认为0，成员次序以创建时间从小到大排列。数量必须和department一致，数值越大排序越前面。有效的值范围是[0, 2^32)
	 * @property string     position            职务信息。长度为0~128个字符
	 * @property string|int gender              性别。1表示男性，2表示女性
	 * @property string     email               邮箱。长度6~64个字节，且为有效的email格式。企业内必须唯一，mobile/email二者不能同时为空
	 * @property string     telephone           座机。32字节以内，由纯数字或’-‘号组成。
	 * @property array      is_leader_in_dept   个数必须和department一致，表示在所在的部门内是否为上级。1表示为上级，0表示非上级。在审批等应用里可以用来标识上级审批人
	 * @property string     avatar              头像url。 第三方仅通讯录应用可获取
	 * @property string     thumb_avatar        头像缩略图url。第三方仅通讯录应用可获取
	 * @property string     avatar_mediaid      成员头像的mediaid，通过素材管理接口上传图片获得的mediaid
	 * @property int        enable              启用/禁用成员。1表示启用成员，0表示禁用成员
	 * @property int        hide_mobile         是否隐藏手机号
	 * @property string     english_name        英文名
	 * @property array      extattr             自定义字段。自定义字段需要先在WEB管理端添加，见扩展属性添加方法，否则忽略未知属性的赋值。与对外属性一致，不过只支持type=0的文本和type=1的网页类型，详细描述查看对外属性
	 * @property boolean    to_invite           是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
	 * @property int        status              激活状态: 1=已激活，2=已禁用，4=未激活。
	 * @property string     qr_code             已激活代表已激活企业微信或已关注微工作台（原企业号）。未激活代表既未激活企业微信又未关注微工作台（原企业号）。
	 * @property array      external_profile    成员对外属性，字段详情见对外属性
	 * @property string     external_position   对外职务，如果设置了该值，则以此作为对外展示的职务，否则以position来展示。长度12个汉字内
	 * @property string     address             地址。长度最大128个字符
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class User
	{
		/**
		 * @param array $arr
		 *
		 * @return User
		 */
		public static function parseFromArray ($arr)
		{
			$user = new User();

			$user->userid            = Utils::arrayGet($arr, 'userid');
			$user->name              = Utils::arrayGet($arr, 'name');
			$user->alias             = Utils::arrayGet($arr, 'alias');
			$user->mobile            = Utils::arrayGet($arr, 'mobile');
			$user->department        = Utils::arrayGet($arr, 'department');
			$user->order             = Utils::arrayGet($arr, 'order');
			$user->position          = Utils::arrayGet($arr, 'position');
			$user->gender            = Utils::arrayGet($arr, 'gender');
			$user->email             = Utils::arrayGet($arr, 'email');
			$user->telephone         = Utils::arrayGet($arr, 'telephone');
			$user->is_leader_in_dept = Utils::arrayGet($arr, 'is_leader_in_dept');
			$user->avatar            = Utils::arrayGet($arr, 'avatar');
			$user->thumb_avatar      = Utils::arrayGet($arr, 'thumb_avatar');
			$user->avatar_mediaid    = Utils::arrayGet($arr, 'avatar_mediaid');
			$user->enable            = Utils::arrayGet($arr, 'enable');
			$user->hide_mobile       = Utils::arrayGet($arr, 'hide_mobile');
			$user->english_name      = Utils::arrayGet($arr, 'english_name');
			$user->extattr           = Attr::parseFromArray(Utils::arrayGet($arr, 'extattr'));
			$user->to_invite         = Utils::arrayGet($arr, 'to_invite');
			$user->status            = Utils::arrayGet($arr, 'status');
			$user->qr_code           = Utils::arrayGet($arr, 'qr_code');
			$user->external_profile  = ExternalProfile::parseFromArray(Utils::arrayGet($arr, 'external_profile'));
			$user->external_position = Utils::arrayGet($arr, 'external_position');
			$user->address           = Utils::arrayGet($arr, 'address');

			return $user;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function Array2UserList ($arr)
		{
			$localUserList = Utils::arrayGet($arr, 'userlist');

			$userList = [];

			if (is_array($localUserList)) {
				foreach ($localUserList as $item) {
					array_push($userList, static::parseFromArray($item));
				}
			}

			return $userList;
		}

		/**
		 * @param User $user
		 *
		 * @throws \ParameterError
		 */
		public static function CheckUserCreateArgs ($user)
		{
			Utils::checkNotEmptyStr($user->userid, "userid");
			Utils::checkNotEmptyStr($user->name, "name");
			Utils::checkNotEmptyArray($user->department, "department");
		}

		/**
		 * @param User $user
		 *
		 * @throws \ParameterError
		 */
		public static function CheckUserUpdateArgs ($user)
		{
			Utils::checkNotEmptyStr($user->userid, "userid");
		}

		/**
		 * @param $userIdList
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckUserBatchDeleteArgs ($userIdList)
		{
			Utils::checkNotEmptyArray($userIdList, "userid list");
			foreach ($userIdList as $userId) {
				Utils::checkNotEmptyStr($userId, "userid");
			}
			if (count($userIdList) > 200) {
				throw new \QyApiError("no more than 200 userid once");
			}
		}
	}