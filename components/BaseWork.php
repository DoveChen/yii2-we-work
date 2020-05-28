<?php

	namespace dovechen\yii2\weWork\components;

	require_once "errorInc/error.inc.php";

	use yii\base\Component;

	abstract class BaseWork extends Component
	{
		public $repJson = NULL;
		public $repRawStr = NULL;

		const SNSAPI_BASE = 'snsapi_base';
		const SNSAPI_USERINFO = 'snsapi_userinfo';
		const SNSAPI_PRIVATEINFO = 'snsapi_privateinfo';

		const GET_TOKEN = '/cgi-bin/gettoken';  // 获取access_token GET

		const GET_API_DOMAIN_IP = '/cgi-bin/get_api_domain_ip?access_token=ACCESS_TOKEN';   // 获取企业微信API域名IP段 GET

		/* 通讯录管理 */
		/* 成员管理 */
		const USER_CREATE = '/cgi-bin/user/create?access_token=ACCESS_TOKEN';   // 创建成员 POST
		const USER_GET = '/cgi-bin/user/get?access_token=ACCESS_TOKEN'; // 读取成员 GET
		const USER_UPDATE = '/cgi-bin/user/update?access_token=ACCESS_TOKEN';   // 更新成员 POST
		const USER_DELETE = '/cgi-bin/user/delete?access_token=ACCESS_TOKEN';   // 删除成员 GET
		const USER_BATCH_DELETE = '/cgi-bin/user/batchdelete?access_token=ACCESS_TOKEN';    // 批量删除成员 POST
		const USER_SIMPLE_LIST = '/cgi-bin/user/simplelist?access_token=ACCESS_TOKEN';  // 获取部门成员 GET
		const USER_LIST = '/cgi-bin/user/list?access_token=ACCESS_TOKEN';   // 获取部门成员详情 GET
		const USER_CONVERT_TO_OPENID = '/cgi-bin/user/convert_to_openid?access_token=ACCESS_TOKEN'; // userid转openid POST
		const USER_CONVERT_TO_USERID = '/cgi-bin/user/convert_to_userid?access_token=ACCESS_TOKEN'; // openid转userid POST
		const USER_AUTHSUCC = '/cgi-bin/user/authsucc?access_token=ACCESS_TOKEN';   // 二次验证 GET
		const BATCH_INVITE = '/cgi-bin/batch/invite?access_token=ACCESS_TOKEN';    // 邀请成员 POST
		const USER_GET_USERID = '/cgi-bin/user/getuserid?access_token=ACCESS_TOKEN';    // 手机号获取userid POST
		const CORP_GET_JOIN_QECODE = '/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN'; // 获取加入企业二维码 GET

		/* 部门管理 */
		const DEPARTMENT_CREATE = '/cgi-bin/department/create?access_token=ACCESS_TOKEN';   // 创建部门 POST
		const DEPARTMENT_UPDATE = '/cgi-bin/department/update?access_token=ACCESS_TOKEN';   // 更新部门 POST
		const DEPARTMENT_DELETE = '/cgi-bin/department/delete?access_token=ACCESS_TOKEN';   // 删除部门 GET
		const DEPARTMENT_LIST = '/cgi-bin/department/list?access_token=ACCESS_TOKEN';   // 获取部门列表 GET

		/* 标签管理 */
		const TAG_CREATE = '/cgi-bin/tag/create?access_token=ACCESS_TOKEN'; // 创建标签 POST
		const TAG_UPDATE = '/cgi-bin/tag/update?access_token=ACCESS_TOKEN'; // 更新标签名字 POST
		const TAG_DELETE = '/cgi-bin/tag/delete?access_token=ACCESS_TOKEN'; // 删除标签 GET
		const TAG_GET = '/cgi-bin/tag/get?access_token=ACCESS_TOKEN';   // 获取标签成员 GET
		const TAG_ADD_TAG_USERS = '/cgi-bin/tag/addtagusers?access_token=ACCESS_TOKEN'; // 增加标签成员 POST
		const TAG_DEL_TAG_USERS = '/cgi-bin/tag/deltagusers?access_token=ACCESS_TOKEN'; // 删除标签成员 POST
		const TAG_LIST = '/cgi-bin/tag/list?access_token=ACCESS_TOKEN'; // 获取标签列表 GET

		/* 异步批量接口 */
		const BATCH_SYNC_USER = '/cgi-bin/batch/syncuser?access_token=ACCESS_TOKEN';    // 增量更新成员 POST
		const BATCH_REPLACE_USER = '/cgi-bin/batch/replaceuser?access_token=ACCESS_TOKEN';  // 全量覆盖成员 POST
		const BATCH_REPLACE_PARTY = '/cgi-bin/batch/replaceparty?access_token=ACCESS_TOKEN';    // 全量覆盖部门 POST
		const BATCH_GET_RESULT = '/cgi-bin/batch/getresult?access_token=ACCESS_TOKEN';  // 获取异步任务结果 GET

		/* 外部联系人管理 */
		/* 企业服务人员管理 */
		const EXTERNAL_CONTACT_GET_FOLLOW_USER_LIST = '/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN';    // 获取配置了客户联系功能的成员列表 GET
		const EXTERNAL_CONTACT_ADD_CONTACT_WAY = '/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN';  // 配置客户联系「联系我」方式 POST
		const EXTERNAL_CONTACT_GET_CONTACT_WAY = '/cgi-bin/externalcontact/get_contact_way?access_token=ACCESS_TOKEN';  // 获取企业已配置的「联系我」方式 POST
		const EXTERNAL_CONTACT_UPDATE_CONTACT_WAY = '/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN';  // 更新企业已配置的「联系我」方式 POST
		const EXTERNAL_CONTACT_DEL_CONTACT_WAY = '/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN';  // 删除企业已配置的「联系我」方式 POST

		/* 客户管理 */
		const EXTERNAL_CONTACT_LIST = '/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN';    // 获取客户列表 GET
		const EXTERNAL_CONTACT_GET = '/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN';    // 获取客户详情 GET
		const EXTERNAL_CONTACT_REMARK = '/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN';    // 修改客户备注信息 POST

		/* 客户标签管理 */
		const EXTERNAL_CONTACT_GET_CORP_TAG_LIST = '/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';  // 获取企业标签库 POST
		const EXTERNAL_CONTACT_ADD_CORP_TAG = '/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN';  // 添加企业客户标签 POST
		const EXTERNAL_CONTACT_EDIT_CORP_TAG = '/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN';  // 编辑企业客户标签 POST
		const EXTERNAL_CONTACT_DEL_CORP_TAG = '/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN';  // 删除企业客户标签 POST
		const EXTERNAL_CONTACT_MARK_TAG = '/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN';  // 编辑客户企业标签 POST

		/* 客户群管理 */
		const EXTERNAL_CONTACT_GROUP_CHAT_LIST = '/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN';    // 获取客户群列表 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_GET = '/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN';    // 获取客户群详情 POST

		/* 消息推送 */
		const EXTERNAL_CONTACT_ADD_MSG_TEMPLATE = '/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN';    // 添加企业群发消息任务 POST
		const EXTERNAL_CONTACT_GET_GROUP_MSG_RESULT = '/cgi-bin/externalcontact/get_group_msg_result?access_token=ACCESS_TOKEN';    // 获取企业群发消息发送结果 POST
		const EXTERNAL_CONTACT_SEND_WELCOME_MSG = '/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN';    // 发送新客户欢迎语 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_ADD = '/cgi-bin/externalcontact/group_welcome_template/add?access_token=ACCESS_TOKEN';    // 添加群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_EDIT = '/cgi-bin/externalcontact/group_welcome_template/edit?access_token=ACCESS_TOKEN';    // 编辑群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_GET = '/cgi-bin/externalcontact/group_welcome_template/get?access_token=ACCESS_TOKEN';    // 获取群欢迎语素材 POST
		const EXTERNAL_CONTACT_GROUP_WELCOME_TEMPLATE_DEL = '/cgi-bin/externalcontact/group_welcome_template/del?access_token=ACCESS_TOKEN';    // 删除群欢迎语素材 POST

		/* 离职管理 */
		const EXTERNAL_CONTACT_GET_UNASSIGNED_LIST = '/cgi-bin/externalcontact/get_unassigned_list?access_token=ACCESS_TOKEN';  // 获取离职成员的客户列表 POST
		const EXTERNAL_CONTACT_TRANSFER = '/cgi-bin/externalcontact/transfer?access_token=ACCESS_TOKEN';  // 离职成员的外部联系人再分配 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_TRANSFER = '/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN';  // 离职成员的群再分配 POST

		/* 统计管理 */
		const EXTERNAL_CONTACT_GET_USER_BEHAVIOR_DATA = '/cgi-bin/externalcontact/get_user_behavior_data?access_token=ACCESS_TOKEN'; // 获取联系客户统计数据 POST
		const EXTERNAL_CONTACT_GROUP_CHAT_STATISTIC = '/cgi-bin/externalcontact/groupchat/statistic?access_token=ACCESS_TOKEN'; // 获取客户群统计数据 POST

		/* 身份验证 */
		/* 网页授权登录 */
		const USR_GET_USER_INFO = '/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN';    // 获取访问用户身份 GET

		/* 应用管理 */
		/* 获取应用 */
		const AGENT_GET = '/cgi-bin/agent/get?access_token=ACCESS_TOKEN';    // 获取指定的应用详情 GET
		const AGENT_LIST = '/cgi-bin/agent/list?access_token=ACCESS_TOKEN';    // 获取access_token对应的应用列表 GET

		/* 设置应用 */
		const AGENT_SET = '/cgi-bin/agent/set?access_token=ACCESS_TOKEN';    // 设置应用 POST

		/* 自定义菜单 */
		const MENU_CREATE = '/cgi-bin/menu/create?access_token=ACCESS_TOKEN';   // 创建菜单 POST
		const MENU_GET = '/cgi-bin/menu/get?access_token=ACCESS_TOKEN';   // 获取菜单 POST
		const MENU_DELETE = '/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';   // 删除菜单 POST

		/* 消息推送 */
		/* 发送应用消息 */
		const MESSAGE_SEND = '/cgi-bin/message/send?access_token=ACCESS_TOKEN'; // 发送应用消息 POST

		/* 更新任务卡片消息状态 */
		const MESSAGE_UPDATE_TASKCARD = '/cgi-bin/message/update_taskcard?access_token=ACCESS_TOKEN';   // 更新任务卡片消息状态 POST

		/* 接收消息与事件 */
		const GET_CALLBACK_IP = '/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';  // 获取企业微信服务器的ip段 GET

		/* 发送消息到群聊会话 */
		const APP_CHAT_CREATE = '/cgi-bin/appchat/create?access_token=ACCESS_TOKEN';    // 创建群聊会话 POST
		const APP_CHAT_UPDATE = '/cgi-bin/appchat/update?access_token=ACCESS_TOKEN';    // 修改群聊会话 POST
		const APP_CHAT_GET = '/cgi-bin/appchat/get?access_token=ACCESS_TOKEN';    // 获取群聊会话 GET
		const APP_CHAT_SEND = '/cgi-bin/appchat/send?access_token=ACCESS_TOKEN';    // 应用推送消息 POST

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
		const CHECKIN_GET_CHECKIN_DATA = '/cgi-bin/checkin/getcheckindata?access_token=ACCESS_TOKEN';   // 获取打卡数据 POST
		const CHECKIN_GET_CHECKIN_OPTION = '/cgi-bin/checkin/getcheckinoption?access_token=ACCESS_TOKEN';   // 获取打卡规则 POST

		/* 企业微信审批应用 */
		const OA_GET_TEMPLATE_DETIAL = '/cgi-bin/oa/gettemplatedetail?access_token=ACCESS_TOKEN';   // 获取审批模板详情 POST
		const OA_APPLY_EVENT = '/cgi-bin/oa/applyevent?access_token=ACCESS_TOKEN';   // 提交审批申请 POST
		const OA_GET_APPROVAL_INFO = '/cgi-bin/oa/getapprovalinfo?access_token=ACCESS_TOKEN';   // 批量获取审批单号 POST
		const OA_GET_APPROVAL_DETAIL = '/cgi-bin/oa/getapprovaldetail?access_token=ACCESS_TOKEN';   // 获取审批申请详情 POST

		/* 企业微信公费电话 */
		const DIAL_GET_DIAL_RECORD = '/cgi-bin/dial/get_dial_record?access_token=ACCESS_TOKEN'; // 获取公费电话拨打记录 POST

		/* 自建应用 */
		const CORP_GET_OPEN_APPROVAL_DATA = '/cgi-bin/corp/getopenapprovaldata?access_token=ACCESS_TOKEN';  // 查询自建应用审批单当前状态 POST

		/* 日程 */
		/* 日程接口 */
		const OA_SCHEDULE_ADD = '/cgi-bin/oa/schedule/add?access_token=ACCESS_TOKEN';   // 创建日程 POST
		const OA_SCHEDULE_UPDATE = '/cgi-bin/oa/schedule/update?access_token=ACCESS_TOKEN';   // 更新日程 POST
		const OA_SCHEDULE_DEL = '/cgi-bin/oa/schedule/del?access_token=ACCESS_TOKEN';   // 取消日程 POST
		const OA_SCHEDULE_GET = '/cgi-bin/oa/schedule/get?access_token=ACCESS_TOKEN';   // 获取日程 POST

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
		const SEND_WORK_WX_REDPACK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendworkwxredpack';   // 发放企业红包 POST
		const QUERY_WORK_WX_REDPACK = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/queryworkwxredpack';   // 查询红包记录 POST

		/* 向员工付款 */
		const PAY_WWSPTRANS_TO_POCKET = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/paywwsptrans2pocket';   // 向员工付款 POST
		const QUERY_WWSPTRANS_TO_POCKET = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/querywwsptrans2pocket';   // 查询付款记录 POST

		/* 获取服务商凭证 */
		const SERVICE_GET_PROVIDER_TOKEN = '/cgi-bin/service/get_provider_token';   // 获取服务商凭证 POST

		/* 应用授权 */
		const SERVICE_GET_SUITE_TOKEN = '/cgi-bin/service/get_suite_token'; // 获取第三方应用凭证 POST
		const SERVICE_GET_PRE_AUTH_CODE = '/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取预授权码 GET
		const SERVICE_SET_SESSION_INFO = '/cgi-bin/service/set_session_info?suite_access_token=SUITE_ACCESS_TOKEN';   // 设置授权配置 POST
		const SERVICE_GET_PERMANENT_CODE = '/cgi-bin/service/get_permanent_code?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业永久授权码 POST
		const SERVICE_GET_AUTH_INFO = '/cgi-bin/service/get_auth_info?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业授权信息 POST
		const SERVICE_GET_CORP_TOKEN = '/cgi-bin/service/get_corp_token?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取企业凭证 POST
		const SERVICE_GET_ADMIN_LIST = '/cgi-bin/service/get_admin_list?suite_access_token=SUITE_ACCESS_TOKEN';   // 获取应用的管理员列表 POST

		/* 身份验证 */
		/* 网页授权登录 */
		const SERVICE_GET_USER_INFO = '/cgi-bin/service/getuserinfo3rd?access_token=SUITE_ACCESS_TOKEN';    // 获取访问用户身份 GET
		const SERVICE_GET_USER_DETIAL = '/cgi-bin/service/getuserdetail3rd?access_token=SUITE_ACCESS_TOKEN';    // 获取访问用户敏感信息 POST

		/* 扫码授权登录 */
		const SERVICE_GET_LOGIN_INFO = '/cgi-bin/service/get_login_info?access_token=PROVIDER_ACCESS_TOKEN';    // 获取登录用户信息 POST

		/* 推广二维码 */
		/* 调用接口 */
		const SERVICE_GET_REGISTER_CODE = '/cgi-bin/service/get_register_code?provider_access_token=PROVIDER_ACCESS_TOKEN'; // 获取注册码 POST
		const SERVICE_GET_REGISTER_INFO = '/cgi-bin/service/get_register_info?provider_access_token=PROVIDER_ACCESS_TOKEN'; // 查询注册状态 POST
		const AGENT_SET_SCOPE = '/cgi-bin/agent/set_scope?access_token='; // 设置授权应用可见范围 POST
		const SYNC_CONTACT_SYNC_SUCCESS = '/cgi-bin/sync/contact_sync_success?access_token='; // 设置通讯录同步完成 GET

		/* 通讯录管理 */
		/* 通讯录搜索 */
		const SERVICE_CONTACT_SEARCH = '/cgi-bin/service/contact/search?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录单个搜索 POST
		const SERVICE_CONTACT_BATCH_SEARCH = '/cgi-bin/service/contact/batchsearch?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录批量搜索 POST

		/* 通讯录ID转译 */
		const SERVICE_MEDIA_UPLOAD = '/cgi-bin/service/media/upload?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 上传需要转译的文件 POST
		const SERVICE_CONTACT_ID_TRANSLATE = '/cgi-bin/service/contact/id_translate?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 异步通讯录id转译 POST
		const SERVICE_BATCH_GET_RESULT = '/cgi-bin/service/batch/getresult?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 获取异步任务结果 GET
		const SERVICE_CONTACT_SORT = '/cgi-bin/service/contact/sort?provider_access_token=PROVIDER_ACCESS_TOKEN';    // 通讯录userid排序 POST

		/* 家校沟通 */
		/* 基础接口 */
		const EXTERNAL_CONTACT_GET_SUBSCRIBE_QRCODE = '/cgi-bin/externalcontact/get_subscribe_qr_code?access_token=ACCESS_TOKEN';   // 获取「学校通知」二维码 GET
		const EXTERNAL_CONTACT_SET_SUBSCRIBE_MODE = '/cgi-bin/externalcontact/set_subscribe_mode?access_token=ACCESS_TOKEN';   // 设置关注「学校通知」的模式 POST
		const EXTERNAL_CONTACT_GET_SUBSCRIBE_MODE = '/cgi-bin/externalcontact/get_subscribe_mode?access_token=ACCESS_TOKEN';   // 获取关注「学校通知」的模式 POST
		const EXTERNAL_CONTACT_MESSAGE_SEND = '/cgi-bin/externalcontact/message/send?access_token=ACCESS_TOKEN';   // 发送「学校通知」 POST
		const EXTERNAL_CONTACT_CONVER_TO_OPENID = '/cgi-bin/externalcontact/convert_to_openid?access_token=ACCESS_TOKEN';   // 外部联系人openid转换 POST

		/* 学生与家长管理 */
		const SCHOOL_USER_CREATE_STUDENT = '/cgi-bin/school/user/create_student?access_token=ACCESS_TOKEN'; // 创建学生 POST
		const SCHOOL_USER_DELETE_STUDENT = '/cgi-bin/school/user/delete_student?access_token=ACCESS_TOKEN'; // 删除学生 GET
		const SCHOOL_USER_UPDATE_STUDENT = '/cgi-bin/school/user/update_student?access_token=ACCESS_TOKEN'; // 更新学生 POST
		const SCHOOL_USER_BATCH_CREATE_STUDENT = '/cgi-bin/school/user/batch_create_student?access_token=ACCESS_TOKEN'; // 批量创建学生 POST
		const SCHOOL_USER_BATCH_DELETE_STUDENT = '/cgi-bin/school/user/batch_delete_student?access_token=ACCESS_TOKEN'; // 批量删除学生 POST
		const SCHOOL_USER_BATCH_UPDATE_STUDENT = '/cgi-bin/school/user/batch_update_student?access_token=ACCESS_TOKEN'; // 批量更新学生 POST
		const SCHOOL_USER_CREATE_PARENT = '/cgi-bin/school/user/create_parent?access_token=ACCESS_TOKEN'; // 创建家长 POST
		const SCHOOL_USER_DELETE_PARENT = '/cgi-bin/school/user/delete_parent?access_token=ACCESS_TOKEN'; // 删除家长 GET
		const SCHOOL_USER_UPDATE_PARENT = '/cgi-bin/school/user/update_parent?access_token=ACCESS_TOKEN'; // 更新家长 POST
		const SCHOOL_USER_BATCH_CREATE_PARENT = '/cgi-bin/school/user/batch_create_parent?access_token=ACCESS_TOKEN'; // 批量创建家长 POST
		const SCHOOL_USER_BATCH_DELETE_PARENT = '/cgi-bin/school/user/batch_delete_parent?access_token=ACCESS_TOKEN'; // 批量删除家长 POST
		const SCHOOL_USER_BATCH_UPDATE_PARENT = '/cgi-bin/school/user/batch_update_parent?access_token=ACCESS_TOKEN'; // 批量更新家长 POST
		const SCHOOL_USER_GET = '/cgi-bin/school/user/get?access_token=ACCESS_TOKEN'; // 读取学生或家长 GET
		const SCHOOL_USER_LIST = '/cgi-bin/school/user/list?access_token=ACCESS_TOKEN'; // 获取部门成员详情 GET
		const SCHOOL_SET_ARCH_SYNC_MODE = '/cgi-bin/school/set_arch_sync_mode?access_token=ACCESS_TOKEN'; // 设置家校通讯录自动同步模式 POST

		/* 部门管理 */
		const SCHOOL_DEPARTMENT_CREATE = '/cgi-bin/school/department/create?access_token=ACCESS_TOKEN'; // 创建部门 POST
		const SCHOOL_DEPARTMENT_UPDATE = '/cgi-bin/school/department/update?access_token=ACCESS_TOKEN'; // 更新部门 POST
		const SCHOOL_DEPARTMENT_DELETE = '/cgi-bin/school/department/delete?access_token=ACCESS_TOKEN'; // 删除部门 GET
		const SCHOOL_DEPARTMENT_LIST = '/cgi-bin/school/department/list?access_token=ACCESS_TOKEN'; // 获取部门列表 GET

		/* 即将废弃接口 */
		const EXTERNAL_CONTACT_LIST_SUBSCRIBER = '/cgi-bin/externalcontact/list_subscriber?access_token=ACCESS_TOKEN';  // 获取已关注「学校通知」的家长列表 POST
		const EXTERNAL_CONTACT_LIST_FOLLOW_RULE = '/cgi-bin/externalcontact/list_follow_rule?access_token=ACCESS_TOKEN';  // 获取家长可添加老师的规则配置 GET
		const EXTERNAL_CONTACT_ADD_FOLLOW_RULE = '/cgi-bin/externalcontact/add_follow_rule?access_token=ACCESS_TOKEN';  // 添加规则配置 POST
		const EXTERNAL_CONTACT_EDIT_FOLLOW_RULE = '/cgi-bin/externalcontact/edit_follow_rule?access_token=ACCESS_TOKEN';  // 编辑规则配置 POST
		const EXTERNAL_CONTACT_DEL_FOLLOW_RULE = '/cgi-bin/externalcontact/del_follow_rule?access_token=ACCESS_TOKEN';  // 删除规则配置 POST
		const EXTERNAL_CONTACT_EDIT_SUBSCRIBER = '/cgi-bin/externalcontact/edit_subscriber?access_token=ACCESS_TOKEN';  // 编辑已关注「学校通知」的家长 POST
		const EXTERNAL_CONTACT_REMOVE_SUBSCRIBER = '/cgi-bin/externalcontact/remove_subscriber?access_token=ACCESS_TOKEN';  // 移除已关注「学校通知」的家长 POST
		const EXTERNAL_CONTACT_ADD_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/add_pending_subsciber?access_token=ACCESS_TOKEN';  // 批量导入家长 POST
		const EXTERNAL_CONTACT_UPDATE_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/update_pending_subsciber?access_token=ACCESS_TOKEN';  // 修改家长信息 POST
		const EXTERNAL_CONTACT_DEL_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/del_pending_subsciber?access_token=ACCESS_TOKEN';  // 批量删除家长 POST
		const EXTERNAL_CONTACT_LIST_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/list_pending_subsciber?access_token=ACCESS_TOKEN';  // 获取家长列表 POST
		const EXTERNAL_CONTACT_GET_PENDING_SUBSCIBER = '/cgi-bin/externalcontact/get_pending_subsciber?access_token=ACCESS_TOKEN';  // 获取家长信息 POST

		/* 设备管理 */
		/* 接口调用 */
		const SERVICE_ADD_DEVICE = '/cgi-bin/service/add_device?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 添加设备实例 POST
		const SERVICE_GET_DEVICE_AUTH_INFO = '/cgi-bin/service/get_device_auth_info?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 查询设备绑定信息 POST
		const SERVICE_RESET_SECRET_NO = '/cgi-bin/service/reset_secret_no?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 重置设备SecretNo POST
		const SERVICE_LIST_DEVICE = '/cgi-bin/service/list_device?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 获取设备列表 POST
		const SERVICE_FETCH_DEVICE_LOG = '/cgi-bin/service/fetch_device_log?provider_access_token=PROVIDER_ACCESS_TOKEN';   // 上传设备日志 POST

		// js-sdk
		const GET_JSAPI_TICKET = '/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN';   // 获取企业的jsapi_ticket
		const TICKET_GET = '/cgi-bin/ticket/get?access_token=ACCESS_TOKEN';   // 获取应用的jsapi_ticket

		/* 会话存档内容 */
		const GET_PERMIT_USER_LIST = '/cgi-bin/msgaudit/get_permit_user_list?access_token=ACCESS_TOKEN'; // 获取会话内容存档开启成员列表
		/* 获取会话同意情况 */
		const CHECK_SINGLE_AGREE = '/cgi-bin/msgaudit/check_single_agree?access_token=ACCESS_TOKEN'; // 单聊请求地址
		const CHECK_ROOM_AGREE = '/cgi-bin/msgaudit/check_room_agree?access_token=ACCESS_TOKEN'; // 群聊请求地址

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
		 * @return \http|mixed
		 *
		 * @throws \HttpError
		 * @throws \NetWorkError
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
					throw new QyApiError("empty response");

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
					throw new QyApiError("empty response");

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
		 * @throws \QyApiError
		 */
		protected function _CheckErrCode ()
		{
			$rsp = $this->repJson;
			$raw = $this->repRawStr;
			if (is_null($rsp))
				return;

			if (!is_array($rsp))
				throw new ParameterError("invalid type " . gettype($rsp));
			if (!array_key_exists("errcode", $rsp)) {
				return;
			}
			$errCode = $rsp["errcode"];
			if (!is_int($errCode))
				throw new \QyApiError(
					"invalid errcode type " . gettype($errCode) . ":" . $raw);
			if ($errCode != 0)
				throw new \QyApiError("response error:" . $raw);
		}
	}