<?php

	namespace dovechen\yii2\weWork\components;

	require_once "errorInc/error.inc.php";

	use yii\base\Component;

	abstract class BaseWork extends Component
	{
		public $repJson   = NULL;
		public $repRawStr = NULL;

		const SNSAPI_BASE        = 'snsapi_base';
		const SNSAPI_USERINFO    = 'snsapi_userinfo';
		const SNSAPI_PRIVATEINFO = 'snsapi_privateinfo';

		const GET_TOKEN = '/cgi-bin/gettoken';  // 获取access_token GET

		const GET_API_DOMAIN_IP = '/cgi-bin/get_api_domain_ip?access_token=ACCESS_TOKEN';   // 获取企业微信API域名IP段 GET

		const ADD_JOIN_WAY    = '/cgi-bin/externalcontact/groupchat/add_join_way?access_token=ACCESS_TOKEN'; //配置客户群进群方式 POST
		const GET_JOIN_WAY    = '/cgi-bin/externalcontact/groupchat/get_join_way?access_token=ACCESS_TOKEN'; //获取客户群进群方式配置 POST
		const UPDATE_JOIN_WAY = '/cgi-bin/externalcontact/groupchat/update_join_way?access_token=ACCESS_TOKEN'; //更新客户群进群方式 POST

		const CALENDAR_ADD = '/cgi-bin/oa/calendar/add?access_token=ACCESS_TOKEN'; //创建日历 POST
		const CALENDAR_GET = '/cgi-bin/oa/calendar/get?access_token=ACCESS_TOKEN'; //获取日历 POST

		/* 通讯录管理 */
		/* 成员管理 */
		const USER_CREATE            = '/cgi-bin/user/create?access_token=ACCESS_TOKEN';   // 创建成员 POST
		const USER_GET               = '/cgi-bin/user/get?access_token=ACCESS_TOKEN'; // 读取成员 GET
		const USER_UPDATE            = '/cgi-bin/user/update?access_token=ACCESS_TOKEN';   // 更新成员 POST
		const USER_DELETE            = '/cgi-bin/user/delete?access_token=ACCESS_TOKEN';   // 删除成员 GET
		const USER_BATCH_DELETE      = '/cgi-bin/user/batchdelete?access_token=ACCESS_TOKEN';    // 批量删除成员 POST
		const USER_SIMPLE_LIST       = '/cgi-bin/user/simplelist?access_token=ACCESS_TOKEN';  // 获取部门成员 GET
		const USER_LIST              = '/cgi-bin/user/list?access_token=ACCESS_TOKEN';   // 获取部门成员详情 GET
		const USER_CONVERT_TO_OPENID = '/cgi-bin/user/convert_to_openid?access_token=ACCESS_TOKEN'; // userid转openid POST
		const USER_CONVERT_TO_USERID = '/cgi-bin/user/convert_to_userid?access_token=ACCESS_TOKEN'; // openid转userid POST
		const USER_AUTHSUCC          = '/cgi-bin/user/authsucc?access_token=ACCESS_TOKEN';   // 二次验证 GET
		const BATCH_INVITE           = '/cgi-bin/batch/invite?access_token=ACCESS_TOKEN';    // 邀请成员 POST
		const USER_GET_USERID        = '/cgi-bin/user/getuserid?access_token=ACCESS_TOKEN';    // 手机号获取userid POST
		const CORP_GET_JOIN_QECODE   = '/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN'; // 获取加入企业二维码 GET
		const GET_MOBILE_HASHCODE    = '/cgi-bin/user/get_mobile_hashcode?access_token=ACCESS_TOKEN'; // 获取手机号随机串 POST

		/* 部门管理 */
		const DEPARTMENT_CREATE = '/cgi-bin/department/create?access_token=ACCESS_TOKEN';   // 创建部门 POST
		const DEPARTMENT_UPDATE = '/cgi-bin/department/update?access_token=ACCESS_TOKEN';   // 更新部门 POST
		const DEPARTMENT_DELETE = '/cgi-bin/department/delete?access_token=ACCESS_TOKEN';   // 删除部门 GET
		const DEPARTMENT_LIST   = '/cgi-bin/department/list?access_token=ACCESS_TOKEN';   // 获取部门列表 GET

		/* 标签管理 */
		const TAG_CREATE        = '/cgi-bin/tag/create?access_token=ACCESS_TOKEN'; // 创建标签 POST
		const TAG_UPDATE        = '/cgi-bin/tag/update?access_token=ACCESS_TOKEN'; // 更新标签名字 POST
		const TAG_DELETE        = '/cgi-bin/tag/delete?access_token=ACCESS_TOKEN'; // 删除标签 GET
		const TAG_GET           = '/cgi-bin/tag/get?access_token=ACCESS_TOKEN';   // 获取标签成员 GET
		const TAG_ADD_TAG_USERS = '/cgi-bin/tag/addtagusers?access_token=ACCESS_TOKEN'; // 增加标签成员 POST
		const TAG_DEL_TAG_USERS = '/cgi-bin/tag/deltagusers?access_token=ACCESS_TOKEN'; // 删除标签成员 POST
		const TAG_LIST          = '/cgi-bin/tag/list?access_token=ACCESS_TOKEN'; // 获取标签列表 GET

		/* 异步批量接口 */
		const BATCH_SYNC_USER     = '/cgi-bin/batch/syncuser?access_token=ACCESS_TOKEN';    // 增量更新成员 POST
		const BATCH_REPLACE_USER  = '/cgi-bin/batch/replaceuser?access_token=ACCESS_TOKEN';  // 全量覆盖成员 POST
		const BATCH_REPLACE_PARTY = '/cgi-bin/batch/replaceparty?access_token=ACCESS_TOKEN';    // 全量覆盖部门 POST
		const BATCH_GET_RESULT    = '/cgi-bin/batch/getresult?access_token=ACCESS_TOKEN';  // 获取异步任务结果 GET

		/* 外部联系人管理 */
		/* 企业服务人员管理 */
		const EXTERNAL_CONTACT_GET_FOLLOW_USER_LIST = '/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN';    // 获取配置了客户联系功能的成员列表 GET
		const EXTERNAL_CONTACT_ADD_CONTACT_WAY      = '/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN';  // 配置客户联系「联系我」方式 POST
		const EXTERNAL_CONTACT_GET_CONTACT_WAY      = '/cgi-bin/externalcontact/get_contact_way?access_token=ACCESS_TOKEN';  // 获取企业已配置的「联系我」方式 POST
		const EXTERNAL_CONTACT_UPDATE_CONTACT_WAY   = '/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN';  // 更新企业已配置的「联系我」方式 POST
		const EXTERNAL_CONTACT_DEL_CONTACT_WAY      = '/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN';  // 删除企业已配置的「联系我」方式 POST

		/* 客户管理 */
		const EXTERNAL_CONTACT_LIST               = '/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN';    // 获取客户列表 GET
		const EXTERNAL_CONTACT_GET                = '/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN';    // 获取客户详情 GET
		const EXTERNAL_CONTACT_BATCH_GET_BY_USER  = '/cgi-bin/externalcontact/batch/get_by_user?access_token=ACCESS_TOKEN';    // 批量获取客户详情 POST
		const EXTERNAL_CONTACT_REMARK             = '/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN';    // 修改客户备注信息 POST
		const EXTERNAL_CONTACT_STRATEGY_LIST      = '/cgi-bin/externalcontact/customer_strategy/list?access_token=ACCESS_TOKEN';    // 获取规则组列表 POST
		const EXTERNAL_CONTACT_STRATEGY_GET       = '/cgi-bin/externalcontact/customer_strategy/get?access_token=ACCESS_TOKEN';    // 获取规则组详情 POST
		const EXTERNAL_CONTACT_STRATEGY_GET_RANGE = '/cgi-bin/externalcontact/customer_strategy/get_range?access_token=ACCESS_TOKEN';    // 获取规则组管理范围 POST
		const EXTERNAL_CONTACT_STRATEGY_CREATE    = '/cgi-bin/externalcontact/customer_strategy/create?access_token=ACCESS_TOKEN';    // 创建新的规则组 POST
		const EXTERNAL_CONTACT_STRATEGY_EDIT      = '/cgi-bin/externalcontact/customer_strategy/edit?access_token=ACCESS_TOKEN';    // 编辑规则组及其管理范围 POST
		const EXTERNAL_CONTACT_STRATEGY_DEL       = '/cgi-bin/externalcontact/customer_strategy/del?access_token=ACCESS_TOKEN';    // 删除规则组 POST

		/* 客户标签管理 */
		const EXTERNAL_CONTACT_GET_CORP_TAG_LIST     = '/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';  // 获取企业标签库 POST
		const EXTERNAL_CONTACT_ADD_CORP_TAG          = '/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN';  // 添加企业客户标签 POST
		const EXTERNAL_CONTACT_EDIT_CORP_TAG         = '/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN';  // 编辑企业客户标签 POST
		const EXTERNAL_CONTACT_DEL_CORP_TAG          = '/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN';  // 删除企业客户标签 POST
		const EXTERNAL_CONTACT_MARK_TAG              = '/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN';  // 编辑客户企业标签 POST
		const EXTERNAL_CONTACT_GET_STRATEGY_TAG_LIST = '/cgi-bin/externalcontact/get_strategy_tag_list?access_token=ACCESS_TOKEN';  // 获取指定规则组下的企业客户标签 POST
		const EXTERNAL_CONTACT_ADD_STRATEGY_TAG      = '/cgi-bin/externalcontact/add_strategy_tag?access_token=ACCESS_TOKEN';  // 为指定规则组创建企业客户标签 POST
		const EXTERNAL_CONTACT_EDIT_STRATEGY_TAG     = '/cgi-bin/externalcontact/edit_strategy_tag?access_token=ACCESS_TOKEN';  // 编辑指定规则组下的企业客户标签 POST
		const EXTERNAL_CONTACT_DEL_STRATEGY_TAG      = '/cgi-bin/externalcontact/del_strategy_tag?access_token=ACCESS_TOKEN';  // 删除指定规则组下的企业客户标签 POST

		/* 客户群管理 */
		const EXTERNAL_CONTACT_GROUP_CHAT_LIST = '/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN';    // 获取客户群列表 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_GET  = '/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN';    // 获取客户群详情 POST
		/**按自然日聚合的方式 群聊数据统计**/
		const EXTERNAL_CONTACT_GROUP_CHAT_STATIC_GET = '/cgi-bin/externalcontact/groupchat/statistic_group_by_day?access_token=ACCESS_TOKEN';    // 获取客户群详情 POST

		/* 消息推送 */
		const EXTERNAL_CONTACT_ADD_MSG_TEMPLATE         = '/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN';    // 添加企业群发消息任务 POST
		const EXTERNAL_CONTACT_GET_GROUP_MSG_RESULT     = '/cgi-bin/externalcontact/get_group_msg_result?access_token=ACCESS_TOKEN';    // 获取企业群发消息发送结果 POST
		const EXTERNAL_CONTACT_GET_GROUP_MSG_TASK       = '/cgi-bin/externalcontact/get_groupmsg_task?access_token=ACCESS_TOKEN';    // 获取群发成员发送任务列表 POST
		const EXTERNAL_CONTACT_GET_GROUPMSG_SEND_RESULT = '/cgi-bin/externalcontact/get_groupmsg_send_result?access_token=ACCESS_TOKEN';    // 获取群发成员发送任务列表 POST
		const EXTERNAL_CONTACT_REMIND_GROUPMSG_SEND     = '/cgi-bin/externalcontact/remind_groupmsg_send?access_token=ACCESS_TOKEN';        // 提醒成员群发 POST
		const EXTERNAL_CONTACT_CANCEL_GROUPMSG_SEND     = '/cgi-bin/externalcontact/cancel_groupmsg_send?access_token=ACCESS_TOKEN';        // 停止企业群发 POST

		const EXTERNAL_CONTACT_SEND_WELCOME_MSG            = '/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN';    // 发送新客户欢迎语 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_ADD  = '/cgi-bin/externalcontact/group_welcome_template/add?access_token=ACCESS_TOKEN';    // 添加群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_EDIT = '/cgi-bin/externalcontact/group_welcome_template/edit?access_token=ACCESS_TOKEN';    // 编辑群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_GET  = '/cgi-bin/externalcontact/group_welcome_template/get?access_token=ACCESS_TOKEN';    // 获取群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_DEL  = '/cgi-bin/externalcontact/group_welcome_template/del?access_token=ACCESS_TOKEN';    // 删除群欢迎语素材 POST

		/* 离职管理 */
		const EXTERNAL_CONTACT_GET_UNASSIGNED_LIST = '/cgi-bin/externalcontact/get_unassigned_list?access_token=ACCESS_TOKEN';  // 获取离职成员的客户列表 POST
		const EXTERNAL_CONTACT_TRANSFER            = '/cgi-bin/externalcontact/transfer?access_token=ACCESS_TOKEN';  // 离职成员的外部联系人再分配 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_TRANSFER = '/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN';  // 离职成员的群再分配 POST
		const EXTERNAL_CONTACT_GET_TRANSFER_RESULT = '/cgi-bin/externalcontact/get_transfer_result?access_token=ACCESS_TOKEN';  // 查询客户接替结果 POST

		/* 离职管理新接口 (老接口企微官方已不再维护) */
		const EXTERNAL_CONTACT_TRANSFER_CUSTOMER = '/cgi-bin/externalcontact/resigned/transfer_customer?access_token=ACCESS_TOKEN';  // 分配离职成员的客户: 企业可通过此接口，分配离职成员的客户给其他成员。 POST
		const EXTERNAL_CONTACT_TRANSFER_RESULT   = '/cgi-bin/externalcontact/resigned/transfer_result?access_token=ACCESS_TOKEN';  // 查询客户接替状态: 企业和第三方可通过此接口查询离职成员的客户分配情况。 POST

		/* 在职继承  查询客户接替状态*/
		const EXTERNALCONTACT_TRANSFER_RESULT = '/cgi-bin/externalcontact/transfer_result?access_token=ACCESS_TOKEN';  // 企业和第三方可通过此接口查询在职成员的客户转接情况。 POST

		/* 统计管理 */
		const EXTERNAL_CONTACT_GET_USER_BEHAVIOR_DATA = '/cgi-bin/externalcontact/get_user_behavior_data?access_token=ACCESS_TOKEN'; // 获取联系客户统计数据 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_STATISTIC   = '/cgi-bin/externalcontact/groupchat/statistic?access_token=ACCESS_TOKEN'; // 获取客户群统计数据 POST

		/* 身份验证 */
		/* 网页授权登录 */
		const USR_GET_USER_INFO    = '/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN';    // 获取访问用户身份 GET
		const USER_GET_USER_DETAIL = '/cgi-bin/user/getuserdetail?access_token=ACCESS_TOKEN';    // 获取访问用户敏感信息 POST

		/* 应用管理 */
		/* 获取应用 */
		const AGENT_GET  = '/cgi-bin/agent/get?access_token=ACCESS_TOKEN';    // 获取指定的应用详情 GET
		const AGENT_LIST = '/cgi-bin/agent/list?access_token=ACCESS_TOKEN';    // 获取access_token对应的应用列表 GET

		/* 设置应用 */
		const AGENT_SET = '/cgi-bin/agent/set?access_token=ACCESS_TOKEN';    // 设置应用 POST

		/* 自定义菜单 */
		const MENU_CREATE = '/cgi-bin/menu/create?access_token=ACCESS_TOKEN';   // 创建菜单 POST
		const MENU_GET    = '/cgi-bin/menu/get?access_token=ACCESS_TOKEN';   // 获取菜单 POST
		const MENU_DELETE = '/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';   // 删除菜单 POST

		/* 消息推送 */
		/* 发送应用消息 */
		const MESSAGE_SEND = '/cgi-bin/message/send?access_token=ACCESS_TOKEN'; // 发送应用消息 POST

		/* 企业发表内容到客户的朋友圈 */
		const MESSAGE_SEND_MOMENT_TASK = '/cgi-bin/externalcontact/add_moment_task?access_token=ACCESS_TOKEN'; // 发送应用消息 POST
		const CANCEL_MOMENT_TASK       = '/cgi-bin/externalcontact/cancel_moment_task?access_token=ACCESS_TOKEN'; // 撤销企业发表朋友圈 POST

		/* 上传附件 */
		const MESSAGE_SEND_UPLOAD_ATTACMENT = '/cgi-bin/media/upload_attachment?access_token=ACCESS_TOKEN'; // 发送应用消息 POST

		/* 更新任务卡片消息状态 */
		const MESSAGE_UPDATE_TASKCARD = '/cgi-bin/message/update_taskcard?access_token=ACCESS_TOKEN';   // 更新任务卡片消息状态 POST

		/* 接收消息与事件 */
		const GET_CALLBACK_IP = '/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';  // 获取企业微信服务器的ip段 GET

		/* 发送消息到群聊会话 */
		const APP_CHAT_CREATE = '/cgi-bin/appchat/create?access_token=ACCESS_TOKEN';    // 创建群聊会话 POST
		const APP_CHAT_UPDATE = '/cgi-bin/appchat/update?access_token=ACCESS_TOKEN';    // 修改群聊会话 POST
		const APP_CHAT_GET    = '/cgi-bin/appchat/get?access_token=ACCESS_TOKEN';    // 获取群聊会话 GET
		const APP_CHAT_SEND   = '/cgi-bin/appchat/send?access_token=ACCESS_TOKEN';    // 应用推送消息 POST

		/* 互联企业消息推送 */
		const LINKED_CORP_MESSAGE_SEND = '/cgi-bin/linkedcorp/message/send?access_token=ACCESS_TOKEN';  // 发送应用消息 POST

		/* 素材管理 */
		/* 上传临时素材 */
		const MEDIA_UPLOAD = '/cgi-bin/media/upload?access_token=ACCESS_TOKEN'; // 上传临时素材 POST

		/* 上传图片 */
		const MEDIA_UPLOAD_IMG = '/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN'; // 上传图片 POST

		/* 获取临时素材 */
		const MEDIA_GET = '/cgi-bin/media/get?access_token=ACCESS_TOKEN'; // 获取临时素材 GET

		/* 获取高清语音素材 */
		const MEDIA_GET_JSSDK = '/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN'; // 获取高清语音素材 GET

		/* OA数据接口 */
		/* 企业微信打卡应用 */
		const CHECKIN_GET_CHECKIN_DATA   = '/cgi-bin/checkin/getcheckindata?access_token=ACCESS_TOKEN';   // 获取打卡数据 POST
		const CHECKIN_GET_CHECKIN_OPTION = '/cgi-bin/checkin/getcheckinoption?access_token=ACCESS_TOKEN';   // 获取打卡规则 POST

		/* 企业微信审批应用 */
		const OA_GET_TEMPLATE_DETIAL = '/cgi-bin/oa/gettemplatedetail?access_token=ACCESS_TOKEN';   // 获取审批模板详情 POST
		const OA_APPLY_EVENT         = '/cgi-bin/oa/applyevent?access_token=ACCESS_TOKEN';   // 提交审批申请 POST
		const OA_GET_APPROVAL_INFO   = '/cgi-bin/oa/getapprovalinfo?access_token=ACCESS_TOKEN';   // 批量获取审批单号 POST
		const OA_GET_APPROVAL_DETAIL = '/cgi-bin/oa/getapprovaldetail?access_token=ACCESS_TOKEN';   // 获取审批申请详情 POST

		const OA_APPROVAL_CREATE_TEMPLATE = '/cgi-bin/oa/approval/create_template?access_token=ACCESS_TOKEN';   // 创建审批模板 POST

		/* 企业微信公费电话 */
		const DIAL_GET_DIAL_RECORD = '/cgi-bin/dial/get_dial_record?access_token=ACCESS_TOKEN'; // 获取公费电话拨打记录 POST

		/* 自建应用 */
		const CORP_GET_OPEN_APPROVAL_DATA = '/cgi-bin/corp/getopenapprovaldata?access_token=ACCESS_TOKEN';  // 查询自建应用审批单当前状态 POST

		/* 日程 */
		/* 日程接口 */
		const OA_SCHEDULE_ADD    = '/cgi-bin/oa/schedule/add?access_token=ACCESS_TOKEN';   // 创建日程 POST
		const OA_SCHEDULE_UPDATE = '/cgi-bin/oa/schedule/update?access_token=ACCESS_TOKEN';   // 更新日程 POST
		const OA_SCHEDULE_DEL    = '/cgi-bin/oa/schedule/del?access_token=ACCESS_TOKEN';   // 取消日程 POST
		const OA_SCHEDULE_GET    = '/cgi-bin/oa/schedule/get?access_token=ACCESS_TOKEN';   // 获取日程 POST

		/* 电子发票 */
		/* 查询电子发票 */
		const CARD_INVOICE_REIMBURSE_GET_INVOICE_INFO = '/cgi-bin/card/invoice/reimburse/getinvoiceinfo?access_token=ACCESS_TOKEN'; // 查询电子发票 POST

		/* 更新发票状态 */
		const CARD_INVOICE_REIMBURSE_UPDATE_INVOICE_STATUS = '/cgi-bin/card/invoice/reimburse/updateinvoicestatus?access_token=ACCESS_TOKEN'; // 更新发票状态 POST

		/* 批量更新发票状态 */
		const CARD_INVOICE_REIMBURSE_UPDATE_STATUS_BATCH = '/cgi-bin/card/invoice/reimburse/updatestatusbatch?access_token=ACCESS_TOKEN'; // 批量更新发票状态 POST

		/* 批量查询电子发票 */
		const CARD_INVOICE_REIMBURSE_GET_INVOICE_INFO_BATCH = '/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch?access_token=ACCESS_TOKEN'; // 批量查询电子发票 POST

		/* 企业支付 */
		/* 企业红包 */
		const SEND_WORK_WX_REDPACK  = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendworkwxredpack';   // 发放企业红包 POST
		const QUERY_WORK_WX_REDPACK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/queryworkwxredpack';   // 查询红包记录 POST

		/* 向员工付款 */
		const PAY_WWSPTRANS_TO_POCKET   = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/paywwsptrans2pocket';   // 向员工付款 POST
		const QUERY_WWSPTRANS_TO_POCKET = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/querywwsptrans2pocket';   // 查询付款记录 POST

		/* 获取服务商凭证 */
		const SERVICE_GET_PROVIDER_TOKEN = '/cgi-bin/service/get_provider_token';   // 获取服务商凭证 POST

		/* 应用授权 */
		const SERVICE_GET_SUITE_TOKEN    = '/cgi-bin/service/get_suite_token'; // 获取第三方应用凭证 POST
		const SERVICE_GET_PRE_AUTH_CODE  = '/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取预授权码 GET
		const SERVICE_SET_SESSION_INFO   = '/cgi-bin/service/set_session_info?suite_access_token=SUITE_ACCESS_TOKEN';   // 设置授权配置 POST
		const SERVICE_GET_PERMANENT_CODE = '/cgi-bin/service/get_permanent_code?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业永久授权码 POST
		const SERVICE_GET_AUTH_INFO      = '/cgi-bin/service/get_auth_info?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业授权信息 POST
		const SERVICE_GET_CORP_TOKEN     = '/cgi-bin/service/get_corp_token?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业凭证 POST
		const SERVICE_GET_ADMIN_LIST     = '/cgi-bin/service/get_admin_list?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取应用的管理员列表 POST

		/* 身份验证 */
		/* 网页授权登录 */
		const SERVICE_GET_USER_INFO   = '/cgi-bin/service/getuserinfo3rd?access_token=SUITE_ACCESS_TOKEN';    // 获取访问用户身份 GET
		const SERVICE_GET_USER_DETIAL = '/cgi-bin/service/getuserdetail3rd?access_token=SUITE_ACCESS_TOKEN';    // 获取访问用户敏感信息 POST

		/* 扫码授权登录 */
		const SERVICE_GET_LOGIN_INFO = '/cgi-bin/service/get_login_info?access_token=PROVIDER_ACCESS_TOKEN';    // 获取登录用户信息 POST

		/* 推广二维码 */
		/* 调用接口 */
		const SERVICE_GET_REGISTER_CODE = '/cgi-bin/service/get_register_code?provider_access_token=PROVIDER_ACCESS_TOKEN'; // 获取注册码 POST
		const SERVICE_GET_REGISTER_INFO = '/cgi-bin/service/get_register_info?provider_access_token=PROVIDER_ACCESS_TOKEN'; // 查询注册状态 POST
		const AGENT_SET_SCOPE           = '/cgi-bin/agent/set_scope?access_token='; // 设置授权应用可见范围 POST
		const SYNC_CONTACT_SYNC_SUCCESS = '/cgi-bin/sync/contact_sync_success?access_token='; // 设置通讯录同步完成 GET

		/* 通讯录管理 */
		/* 通讯录搜索 */
		const SERVICE_CONTACT_SEARCH       = '/cgi-bin/service/contact/search?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录单个搜索 POST
		const SERVICE_CONTACT_BATCH_SEARCH = '/cgi-bin/service/contact/batchsearch?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录批量搜索 POST

		/* 通讯录ID转译 */
		const SERVICE_MEDIA_UPLOAD         = '/cgi-bin/service/media/upload?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 上传需要转译的文件 POST
		const SERVICE_CONTACT_ID_TRANSLATE = '/cgi-bin/service/contact/id_translate?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 异步通讯录id转译 POST
		const SERVICE_BATCH_GET_RESULT     = '/cgi-bin/service/batch/getresult?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 获取异步任务结果 GET
		const SERVICE_CONTACT_SORT         = '/cgi-bin/service/contact/sort?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录userid排序 POST

		/* 家校沟通 */
		/* 基础接口 */
		const EXTERNAL_CONTACT_GET_SUBSCRIBE_QRCODE = '/cgi-bin/externalcontact/get_subscribe_qr_code?access_token=ACCESS_TOKEN';   // 获取「学校通知」二维码 GET
		const EXTERNAL_CONTACT_SET_SUBSCRIBE_MODE   = '/cgi-bin/externalcontact/set_subscribe_mode?access_token=ACCESS_TOKEN';   // 设置关注「学校通知」的模式 POST
		const EXTERNAL_CONTACT_GET_SUBSCRIBE_MODE   = '/cgi-bin/externalcontact/get_subscribe_mode?access_token=ACCESS_TOKEN';   // 获取关注「学校通知」的模式 POST
		const EXTERNAL_CONTACT_MESSAGE_SEND         = '/cgi-bin/externalcontact/message/send?access_token=ACCESS_TOKEN';   // 发送「学校通知」 POST
		const EXTERNAL_CONTACT_CONVER_TO_OPENID     = '/cgi-bin/externalcontact/convert_to_openid?access_token=ACCESS_TOKEN';   // 外部联系人openid转换 POST

		/* 学生与家长管理 */
		const SCHOOL_USER_CREATE_STUDENT       = '/cgi-bin/school/user/create_student?access_token=ACCESS_TOKEN'; // 创建学生 POST
		const SCHOOL_USER_DELETE_STUDENT       = '/cgi-bin/school/user/delete_student?access_token=ACCESS_TOKEN'; // 删除学生 GET
		const SCHOOL_USER_UPDATE_STUDENT       = '/cgi-bin/school/user/update_student?access_token=ACCESS_TOKEN'; // 更新学生 POST
		const SCHOOL_USER_BATCH_CREATE_STUDENT = '/cgi-bin/school/user/batch_create_student?access_token=ACCESS_TOKEN'; // 批量创建学生 POST
		const SCHOOL_USER_BATCH_DELETE_STUDENT = '/cgi-bin/school/user/batch_delete_student?access_token=ACCESS_TOKEN'; // 批量删除学生 POST
		const SCHOOL_USER_BATCH_UPDATE_STUDENT = '/cgi-bin/school/user/batch_update_student?access_token=ACCESS_TOKEN'; // 批量更新学生 POST
		const SCHOOL_USER_CREATE_PARENT        = '/cgi-bin/school/user/create_parent?access_token=ACCESS_TOKEN'; // 创建家长 POST
		const SCHOOL_USER_DELETE_PARENT        = '/cgi-bin/school/user/delete_parent?access_token=ACCESS_TOKEN'; // 删除家长 GET
		const SCHOOL_USER_UPDATE_PARENT        = '/cgi-bin/school/user/update_parent?access_token=ACCESS_TOKEN'; // 更新家长 POST
		const SCHOOL_USER_BATCH_CREATE_PARENT  = '/cgi-bin/school/user/batch_create_parent?access_token=ACCESS_TOKEN'; // 批量创建家长 POST
		const SCHOOL_USER_BATCH_DELETE_PARENT  = '/cgi-bin/school/user/batch_delete_parent?access_token=ACCESS_TOKEN'; // 批量删除家长 POST
		const SCHOOL_USER_BATCH_UPDATE_PARENT  = '/cgi-bin/school/user/batch_update_parent?access_token=ACCESS_TOKEN'; // 批量更新家长 POST
		const SCHOOL_USER_GET                  = '/cgi-bin/school/user/get?access_token=ACCESS_TOKEN'; // 读取学生或家长 GET
		const SCHOOL_USER_LIST                 = '/cgi-bin/school/user/list?access_token=ACCESS_TOKEN'; // 获取部门成员详情 GET
		const SCHOOL_SET_ARCH_SYNC_MODE        = '/cgi-bin/school/set_arch_sync_mode?access_token=ACCESS_TOKEN'; // 设置家校通讯录自动同步模式 POST

		/* 部门管理 */
		const SCHOOL_DEPARTMENT_CREATE = '/cgi-bin/school/department/create?access_token=ACCESS_TOKEN'; // 创建部门 POST
		const SCHOOL_DEPARTMENT_UPDATE = '/cgi-bin/school/department/update?access_token=ACCESS_TOKEN'; // 更新部门 POST
		const SCHOOL_DEPARTMENT_DELETE = '/cgi-bin/school/department/delete?access_token=ACCESS_TOKEN'; // 删除部门 GET
		const SCHOOL_DEPARTMENT_LIST   = '/cgi-bin/school/department/list?access_token=ACCESS_TOKEN'; // 获取部门列表 GET

		/* 即将废弃接口 */
		const EXTERNAL_CONTACT_LIST_SUBSCRIBER          = '/cgi-bin/externalcontact/list_subscriber?access_token=ACCESS_TOKEN';  // 获取已关注「学校通知」的家长列表 POST
		const EXTERNAL_CONTACT_LIST_FOLLOW_RULE         = '/cgi-bin/externalcontact/list_follow_rule?access_token=ACCESS_TOKEN';  // 获取家长可添加老师的规则配置 GET
		const EXTERNAL_CONTACT_ADD_FOLLOW_RULE          = '/cgi-bin/externalcontact/add_follow_rule?access_token=ACCESS_TOKEN';  // 添加规则配置 POST
		const EXTERNAL_CONTACT_EDIT_FOLLOW_RULE         = '/cgi-bin/externalcontact/edit_follow_rule?access_token=ACCESS_TOKEN';  // 编辑规则配置 POST
		const EXTERNAL_CONTACT_DEL_FOLLOW_RULE          = '/cgi-bin/externalcontact/del_follow_rule?access_token=ACCESS_TOKEN';  // 删除规则配置 POST
		const EXTERNAL_CONTACT_EDIT_SUBSCRIBER          = '/cgi-bin/externalcontact/edit_subscriber?access_token=ACCESS_TOKEN';  // 编辑已关注「学校通知」的家长 POST
		const EXTERNAL_CONTACT_REMOVE_SUBSCRIBER        = '/cgi-bin/externalcontact/remove_subscriber?access_token=ACCESS_TOKEN';  // 移除已关注「学校通知」的家长 POST
		const EXTERNAL_CONTACT_ADD_PENDING_SUBSCIBER    = '/cgi-bin/externalcontact/add_pending_subsciber?access_token=ACCESS_TOKEN';  // 批量导入家长 POST
		const EXTERNAL_CONTACT_UPDATE_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/update_pending_subsciber?access_token=ACCESS_TOKEN';  // 修改家长信息 POST
		const EXTERNAL_CONTACT_DEL_PENDING_SUBSCIBER    = '/cgi-bin/externalcontact/del_pending_subsciber?access_token=ACCESS_TOKEN';  // 批量删除家长 POST
		const EXTERNAL_CONTACT_LIST_PENDING_SUBSCIBER   = '/cgi-bin/externalcontact/list_pending_subsciber?access_token=ACCESS_TOKEN';  // 获取家长列表 POST
		const EXTERNAL_CONTACT_GET_PENDING_SUBSCIBER    = '/cgi-bin/externalcontact/get_pending_subsciber?access_token=ACCESS_TOKEN';  // 获取家长信息 POST

		/* 设备管理 */
		/* 接口调用 */
		const SERVICE_ADD_DEVICE           = '/cgi-bin/service/add_device?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 添加设备实例 POST
		const SERVICE_GET_DEVICE_AUTH_INFO = '/cgi-bin/service/get_device_auth_info?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 查询设备绑定信息 POST
		const SERVICE_RESET_SECRET_NO      = '/cgi-bin/service/reset_secret_no?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 重置设备SecretNo POST
		const SERVICE_LIST_DEVICE          = '/cgi-bin/service/list_device?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 获取设备列表 POST
		const SERVICE_FETCH_DEVICE_LOG     = '/cgi-bin/service/fetch_device_log?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 上传设备日志 POST

		// js-sdk
		const GET_JSAPI_TICKET       = '/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN';   // 获取企业的jsapi_ticket
		const GET_SUITE_JSAPI_TICKET = '/cgi-bin/get_jsapi_ticket?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取服务上下企业的jsapi_ticket
		const TICKET_GET             = '/cgi-bin/ticket/get?access_token=ACCESS_TOKEN';   // 获取应用的jsapi_ticket

		/* 会话存档内容 */
		const GET_PERMIT_USER_LIST = '/cgi-bin/msgaudit/get_permit_user_list?access_token=ACCESS_TOKEN'; // 获取会话内容存档开启成员列表
		/* 获取会话同意情况 */
		const CHECK_SINGLE_AGREE = '/cgi-bin/msgaudit/check_single_agree?access_token=ACCESS_TOKEN'; // 单聊请求地址
		const CHECK_ROOM_AGREE   = '/cgi-bin/msgaudit/check_room_agree?access_token=ACCESS_TOKEN'; // 群聊请求地址
		/* 获取会话内容存档内部群信息 */
		const GROUP_CHAT_GET = '/cgi-bin/msgaudit/groupchat/get?access_token=ACCESS_TOKEN'; // 获取会话内容存档内部群信息请求地址
		/* 获取客户朋友圈 */
		const GET_MOMENT_LIST          = '/cgi-bin/externalcontact/get_moment_list?access_token=ACCESS_TOKEN'; // 获取企业全部的发表列表
		const GET_MOMENT_TASK          = '/cgi-bin/externalcontact/get_moment_task?access_token=ACCESS_TOKEN'; // 获取客户朋友圈企业发表的列表
		const GET_MOMENT_CUSTOMER_LIST = '/cgi-bin/externalcontact/get_moment_customer_list?access_token=ACCESS_TOKEN'; // 获取客户朋友圈发表时选择的可见范围
		const GET_MOMENT_SEND_RESULT   = '/cgi-bin/externalcontact/get_moment_send_result?access_token=ACCESS_TOKEN'; // 获取客户朋友圈发表后的可见客户列表
		const GET_MOMENT_COMMENTS      = '/cgi-bin/externalcontact/get_moment_comments?access_token=ACCESS_TOKEN'; // 获取客户朋友圈的互动数据
		const GET_MOMENT_TASK_RESULT   = '/cgi-bin/externalcontact/get_moment_task_result?access_token=ACCESS_TOKEN'; // 企业发表朋友圈  获取任务创建结果   jobid换moment_id

		/* 微信客服 */
		/* 客服帐号管理 */
		const WECHAT_KF_ACCOUNT_ADD     = '/cgi-bin/kf/account/add?access_token=ACCESS_TOKEN'; // 添加客服帐号
		const WECHAT_KF_ACCOUNT_DEL     = '/cgi-bin/kf/account/del?access_token=ACCESS_TOKEN';//删除客服帐号
		const WECHAT_KF_ACCOUNT_UPDATE  = '/cgi-bin/kf/account/update?access_token=ACCESS_TOKEN';//修改客服账号
		const WECHAT_KF_ACCOUNT_LIST    = '/cgi-bin/kf/account/list?access_token=ACCESS_TOKEN';//获取客服账号列表
		const WECHAT_KF_ADD_CONTACT_WAY = '/cgi-bin/kf/add_contact_way?access_token=ACCESS_TOKEN';//获取客服帐号链接
		/* 接待人员管理 */
		const WECHAT_KF_SERVICER_ADD  = '/cgi-bin/kf/servicer/add?access_token=ACCESS_TOKEN';//添加接待人员
		const WECHAT_KF_SERVICER_DEL  = '/cgi-bin/kf/servicer/del?access_token=ACCESS_TOKEN';//删除接待人员
		const WECHAT_KF_SERVICER_LIST = '/cgi-bin/kf/servicer/list?access_token=ACCESS_TOKEN';//获取接待人员列表
		/* 会话分配与消息收发 */
		const WECHAT_KF_SERVICER_STATE_GET   = '/cgi-bin/kf/service_state/get?access_token=ACCESS_TOKEN';//获取会话状态
		const WECHAT_KF_SERVICER_STATE_TRANS = '/cgi-bin/kf/service_state/trans?access_token=ACCESS_TOKEN';//变更会话状态
		const WECHAT_KF_SYNC_MSG             = '/cgi-bin/kf/sync_msg?access_token=ACCESS_TOKEN';//获取消息
		const WECHAT_KF_SEND_MSG             = '/cgi-bin/kf/send_msg?access_token=ACCESS_TOKEN';//发送消息
		const WECHAT_KF_SEND_MSG_ON_EVENT    = '/cgi-bin/kf/send_msg_on_event?access_token=ACCESS_TOKEN';//发送欢迎语等事件响应消息
		/* 「升级服务」配置 */
		const WECHAT_KF_CUSTOMER_GET_UPGRADE_SERVICE_CONFIG = '/cgi-bin/kf/customer/get_upgrade_service_config?access_token=ACCESS_TOKEN';//获取配置的专员与客户群
		const WECHAT_KF_CUSTOMER_UPGRADE_SERVICE            = '/cgi-bin/kf/customer/upgrade_service?access_token=ACCESS_TOKEN';//升级专员/客户群服务
		const WECHAT_KF_CUSTOMER_CANCEL_UPGRADE_SERVICE     = '/cgi-bin/kf/customer/cancel_upgrade_service?access_token=ACCESS_TOKEN';//为客户取消推荐

		/* 统计管理 */
		const WECHAT_KF_GET_CORP_STATISTIC     = '/cgi-bin/kf/get_corp_statistic?access_token=ACCESS_TOKEN';//获取「客户数据统计」企业汇总数据
		const WECHAT_KF_GET_SERVICER_STATISTIC = '/cgi-bin/kf/get_servicer_statistic?access_token=ACCESS_TOKEN';//获取「客户数据统计」接待人员明细数据

		/* 其他基础信息获取 */
		const WECHAT_KF_CUSTOMER_BATCHGET = '/cgi-bin/kf/customer/batchget?access_token=ACCESS_TOKEN';//客户基本信息获取

		/* 代开发应用与第三方应用的兼容 */
		const TO_OPEN_CORPID             = '/cgi-bin/corp/to_open_corpid?access_token=ACCESS_TOKEN'; // corpid的转换
		const USERID_TO_OPENUSERID       = '/cgi-bin/batch/userid_to_openuserid?access_token=ACCESS_TOKEN'; // userid的转换
		const TO_SERVICE_EXTERNAL_USERID = '/cgi-bin/externalcontact/to_service_external_userid?access_token=ACCESS_TOKEN'; // external_userid的转换

		/* 企业微信帐号ID安全性全面升级 */
		const GET_NEW_EXTERNAL_USERID          = '/cgi-bin/externalcontact/get_new_external_userid?access_token=ACCESS_TOKEN';   // 转换external_userid
		const FINISH_EXTERNAL_USERID_MIGRATION = '/cgi-bin/service/externalcontact/finish_external_userid_migration?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 设置迁移完成
		const UNIONID_TO_EXTERNAL_USERID_3RD   = '/cgi-bin/service/externalcontact/unionid_to_external_userid_3rd?suite_access_token=SUITE_ACCESS_TOKEN';   // unionid查询external_userid

		/* 明文corpid转换为加密corpid */
		const CORPID_TO_OPENCORPID = '/cgi-bin/service/corpid_to_opencorpid?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 明文corpid转换为加密corpid

		/* 自建应用与第三方应用的对接 */
		const OPENUSERID_TO_USERID         = '/cgi-bin/batch/openuserid_to_userid?access_token=ACCESS_TOKEN';   // userid转换
		const FROM_SERVICE_EXTERNAL_USERID = '/cgi-bin/externalcontact/from_service_external_userid?access_token=ACCESS_TOKEN';   // external_userid转换

		protected function GetAccessToken ($force = false)
		{
		}

		protected function RefreshAccessToken ()
		{
		}

		protected function GetSuiteAccessToken ($force = false)
		{
		}

		protected function RefreshSuiteAccessToken ()
		{
		}

		protected function GetProviderAccessToken ($force = false)
		{
		}

		protected function RefreshProviderAccessToken ()
		{
		}

		protected function GetOauth2Url ($appid, $redirectUri, $state, $scope = self::SNSAPI_BASE)
		{
		}

		protected function GetAgentOauth2Url ($appid, $redirectUri, $state, $scope = self::SNSAPI_BASE, $agentId = '')
		{
		}

		/**
		 * 数据缓存基本键值
		 *
		 * @param $name
		 *
		 * @return string
		 */
		abstract protected function getCacheKey ($name);

		/**
		 * 微信数据
		 *
		 * @param      $name
		 * @param      $value
		 * @param null $duration
		 *
		 * @return bool
		 */
		protected function setCache ($name, $value, $duration = NULL)
		{
			$duration === NULL && $duration = $this->cacheTime;

			return \Yii::$app->cache->set($this->getCacheKey($name), $value, $duration);
		}

		/**
		 * 获取缓存数据
		 *
		 * @param $name
		 *
		 * @return mixed
		 */
		protected function getCache ($name)
		{
			return \Yii::$app->cache->get($this->getCacheKey($name));
		}

		/**
		 * @param        $url
		 * @param string $method
		 * @param array  $args
		 * @param bool   $refreshTokenWhenExpired
		 * @param bool   $isPostFile
		 *
		 * @throws \HttpError
		 * @throws \NetWorkError
		 * @throws \QyApiError
		 */
		protected function _HttpCall ($url, $method = "GET", $args = [], $refreshTokenWhenExpired = true, $isPostFile = false)
		{
			if ('POST' == strtoupper($method)) {
				$url = HttpUtils::MakeUrl($url);
				$this->_HttpPostParseToJson($url, $args, $refreshTokenWhenExpired, $isPostFile);
				$this->_CheckErrCode();
			} else if ('GET' == strtoupper($method)) {
				if (count($args) > 0) {
					foreach ($args as $key => $value) {
						if ($value == NULL)
							continue;
						if (strpos($url, '?')) {
							$url .= ('&' . $key . '=' . $value);
						} else {
							$url .= ('?' . $key . '=' . $value);
						}
					}
				}
				$url = HttpUtils::MakeUrl($url);
				$this->_HttpGetParseToJson($url);
				$this->_CheckErrCode();
			} else {
				throw new \QyApiError('wrong method');
			}
		}

		/**
		 * @param      $url
		 * @param bool $refreshTokenWhenExpired
		 *
		 * @return bool|\http|string
		 *
		 * @throws \HttpError
		 * @throws \NetWorkError
		 * @throws \QyApiError
		 */
		protected function _HttpGetParseToJson ($url, $refreshTokenWhenExpired = true)
		{
			$retryCnt        = 0;
			$this->repJson   = NULL;
			$this->repRawStr = NULL;

			while ($retryCnt < 2) {
				$tokenType = NULL;
				$realUrl   = $url;

				if (strpos($url, "SUITE_ACCESS_TOKEN")) {
					$token     = $this->GetSuiteAccessToken();
					$realUrl   = str_replace("SUITE_ACCESS_TOKEN", $token, $url);
					$tokenType = "SUITE_ACCESS_TOKEN";
				} else if (strpos($url, "PROVIDER_ACCESS_TOKEN")) {
					$token     = $this->GetProviderAccessToken();
					$realUrl   = str_replace("PROVIDER_ACCESS_TOKEN", $token, $url);
					$tokenType = "PROVIDER_ACCESS_TOKEN";
				} else if (strpos($url, "ACCESS_TOKEN")) {
					$token     = $this->GetAccessToken();
					$realUrl   = str_replace("ACCESS_TOKEN", $token, $url);
					$tokenType = "ACCESS_TOKEN";
				} else {
					$tokenType = "NO_TOKEN";
				}

				$this->repRawStr = HttpUtils::httpGet($realUrl);

				if (!Utils::notEmptyStr($this->repRawStr))
					throw new \QyApiError("empty response");

				$this->repJson = json_decode($this->repRawStr, true);
				if (strpos($this->repRawStr, "errcode") !== false) {
					$errCode = Utils::arrayGet($this->repJson, "errcode");
					if ($errCode == 40014 || $errCode == 42001 || $errCode == 42007 || $errCode == 42009) { // token expired
						if ("NO_TOKEN" != $tokenType && true == $refreshTokenWhenExpired) {
							if ("ACCESS_TOKEN" == $tokenType) {
								$result = $this->RefreshAccessToken();
								$this->SetAccessToken($result);
							} else if ("SUITE_ACCESS_TOKEN" == $tokenType) {
								$result = $this->RefreshSuiteAccessToken();
								$this->SetSuiteAccessToken($result);
							} else if ("PROVIDER_ACCESS_TOKEN" == $tokenType) {
								$result = $this->RefreshProviderAccessToken();
								$this->SetProviderAccessToken($result);
							}
							$retryCnt += 1;
							continue;
						}
					}
				}

				return $this->repRawStr;
			}
		}

		/**
		 * @param      $url
		 * @param      $args
		 * @param bool $refreshTokenWhenExpired
		 * @param bool $isPostFile
		 *
		 * @return mixed
		 *
		 * @throws \HttpError
		 * @throws \NetWorkError
		 * @throws \QyApiError
		 */
		protected function _HttpPostParseToJson ($url, $args, $refreshTokenWhenExpired = true, $isPostFile = false)
		{
			$postData = $args;
			if (!$isPostFile) {
				if (!is_string($args)) {
					$postData = HttpUtils::Array2Json($args);
				}
			}
			$this->repJson   = NULL;
			$this->repRawStr = NULL;

			$retryCnt = 0;
			while ($retryCnt < 2) {
				$tokenType = NULL;
				$realUrl   = $url;

				if (strpos($url, "SUITE_ACCESS_TOKEN")) {
					$token     = $this->GetSuiteAccessToken();
					$realUrl   = str_replace("SUITE_ACCESS_TOKEN", $token, $url);
					$tokenType = "SUITE_ACCESS_TOKEN";
				} else if (strpos($url, "PROVIDER_ACCESS_TOKEN")) {
					$token     = $this->GetProviderAccessToken();
					$realUrl   = str_replace("PROVIDER_ACCESS_TOKEN", $token, $url);
					$tokenType = "PROVIDER_ACCESS_TOKEN";
				} else if (strpos($url, "ACCESS_TOKEN")) {
					$token     = $this->GetAccessToken();
					$realUrl   = str_replace("ACCESS_TOKEN", $token, $url);
					$tokenType = "ACCESS_TOKEN";
				} else {
					$tokenType = "NO_TOKEN";
				}

				$this->repRawStr = HttpUtils::httpPost($realUrl, $postData);

				if (!Utils::notEmptyStr($this->repRawStr))
					throw new \QyApiError("empty response");

				$json          = json_decode($this->repRawStr, true/*to array*/);
				$this->repJson = $json;

				$errCode = Utils::arrayGet($this->repJson, "errcode");
				if ($errCode == 40014 || $errCode == 42001 || $errCode == 42007 || $errCode == 42009) { // token expired
					if ("NO_TOKEN" != $tokenType && true == $refreshTokenWhenExpired) {
						if ("ACCESS_TOKEN" == $tokenType) {
							$result = $this->RefreshAccessToken();
							$this->SetAccessToken($result);
						} else if ("SUITE_ACCESS_TOKEN" == $tokenType) {
							$result = $this->RefreshSuiteAccessToken();
							$this->SetSuiteAccessToken($result);
						} else if ("PROVIDER_ACCESS_TOKEN" == $tokenType) {
							$result = $this->RefreshProviderAccessToken();
							$this->SetProviderAccessToken($result);
						}
						$retryCnt += 1;
						continue;
					}
				}

				return $json;
			}
		}

		/**
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		protected function _CheckErrCode ()
		{
			$rsp = $this->repJson;
			$raw = $this->repRawStr;
			if (is_null($rsp))
				return;

			if (!is_array($rsp))
				throw new \ParameterError("invalid type " . gettype($rsp));
			if (!array_key_exists("errcode", $rsp)) {
				return;
			}
			$errCode = $rsp["errcode"];
			$errInfo = errorCode::getErrorInfo($errCode);

			if (!is_null($errInfo)) {
				$raw           = json_decode($raw, true);
				$raw['errmsg'] = $errInfo;
				$raw           = json_encode($raw, JSON_UNESCAPED_UNICODE);
			}
			if (!is_int($errCode))
				throw new \QyApiError(
					"invalid errcode type " . gettype($errCode) . ":" . $raw);
			if ($errCode != 0)
				throw new \QyApiError("response error:" . $raw);
		}
	}