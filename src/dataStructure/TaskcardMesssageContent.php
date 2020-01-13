<?php
	/**
	 * Create by PhpStorm
	 * User: dovechen
	 * Date: 2020/1/13
	 * Time: 11:24
	 */

	namespace dovechen\yii2\weWork\src\dataStructure;

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class TaskcardMesssageContent
	 *
	 * @property string $msgtype             消息类型，此时固定为：taskcard
	 * @property string $title               标题，不超过128个字节，超过会自动截断
	 * @property string $description         描述，不超过512个字节，超过会自动截断
	 * @property string $url                 点击后跳转的链接。最长2048字节，请确保包含了协议头(http/https)
	 * @property string $task_id             任务id，同一个应用发送的任务卡片消息的任务id不能重复，只能由数字、字母和“_-@.”组成，最长支持128字节
	 * @property array  $btn                 按钮列表，按钮个数为为1~2个。
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class TaskcardMesssageContent
	{
		const MSG_TYPE = 'taskcard';

		/**
		 * @param $arr
		 *
		 * @return TaskcardMesssageContent
		 */
		public static function parseFromArray ($arr)
		{
			$taskcard = new TaskcardMesssageContent();

			$taskcard->title       = Utils::arrayGet($arr, 'title');
			$taskcard->description = Utils::arrayGet($arr, 'description');
			$taskcard->url         = Utils::arrayGet($arr, 'url');
			$taskcard->task_id     = Utils::arrayGet($arr, 'task_id');
			$taskcard->btn         = [];

			$btn = Utils::arrayGet($arr, 'btn');
			if (!is_null($btn)) {
				foreach ($btn as $item) {
					array_push($taskcard->btn, TaskcardBtn::parseFromArray($item));
				}
			}

			return $taskcard;
		}

		/**
		 * @param TaskcardMesssageContent $args
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckMessageSendArgs ($args)
		{
			Utils::checkNotEmptyStr($args->msgtype, 'msgtype');

			if ($args->msgtype != static::MSG_TYPE) {
				throw new \QyApiError("msgtype invalid.");
			}

			Utils::checkNotEmptyStr($args->title, 'title');
			Utils::checkNotEmptyStr($args->description, 'description');
			Utils::checkNotEmptyStr($args->task_id, 'task_id');
			Utils::checkNotEmptyArray($args->btn, 'btn');

			if (count($args->btn) > 2) {
				throw new \QyApiError('btn only can be one or two');
			}

			foreach ($args->btn as $btn) {
				TaskcardBtn::CheckMessageSendArgs($btn);
			}
		}

		/**
		 * @param TaskcardMesssageContent $content
		 * @param                         $arr
		 */
		public static function MessageContent2Array ($content, &$arr)
		{
			Utils::setIfNotNull($content->msgtype, "msgtype", $arr);

			$args = [];
			Utils::setIfNotNull($content->title, "title", $args);
			Utils::setIfNotNull($content->description, "description", $args);
			Utils::setIfNotNull($content->url, "url", $args);
			Utils::setIfNotNull($content->task_id, "task_id", $args);

			$args['btn'] = [];
			foreach ($content->btn as $item) {
				array_push($args['btn'], TaskcardBtn::taskcardBtn2Array($item));
			}

			Utils::setIfNotNull($args, $content->msgtype, $arr);
		}
	}