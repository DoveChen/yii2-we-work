<?php

	namespace dovechen\yii2\weWork\src\dataStructure;

	include_once __DIR__ . "/../../components/errorInc/error.inc.php";

	use dovechen\yii2\weWork\components\Utils;

	/**
	 * Class Tags
	 *
	 * @property int    $tagid      标签id，非负整型，指定此参数时新增的标签会生成对应的标签id，不指定时则以目前最大的id自增。
	 * @property string $tagname    标签名称，长度限制为32个字以内（汉字或英文字母），标签名不可与其他标签重名。
	 * @property array  $userlist   标签中包含的成员列表
	 * @property array  $partylist  标签中包含的部门id列表
	 *
	 * @package dovechen\yii2\weWork\src\dataStructure
	 */
	class Tag
	{
		/**
		 * @param array $arr
		 *
		 * @return Tag
		 */
		public static function parseFromArray ($arr)
		{
			$tag = new Tag();

			$tag->tagid   = Utils::arrayGet($arr, "tagid");
			$tag->tagname = Utils::arrayGet($arr, "tagname");

			$userListArr = Utils::arrayGet($arr, "userlist");
			if (!is_null($userListArr)) {
				$tag->userlist = [];
				foreach ($userListArr as $userArr) {
					array_push($tag->userlist, TagUser::parseFromArray($userArr));
				}
			}

			$partyListArr = Utils::arrayGet($arr, "partylist");
			if (!is_null($partyListArr)) {
				$tag->partylist = [];
				foreach ($partyListArr as $partyid) {
					array_push($tag->partylist, $partyid);
				}
			}

			return $tag;
		}

		/**
		 * @param Tag $tag
		 *
		 * @return array
		 */
		public static function Tag2Array ($tag)
		{
			$arr = [];

			Utils::setIfNotNull($tag->tagname, "tagname", $arr);
			Utils::setIfNotNull($tag->tagid, "tagid", $arr);

			return $arr;
		}

		/**
		 * @param array $arr
		 *
		 * @return array
		 */
		public static function Array2TagList ($arr)
		{
			$tagList = [];

			$tagListArr = Utils::arrayGet($arr, "taglist");

			if (is_array($tagListArr)) {
				foreach ($tagListArr as $item) {
					array_push($tagList, static::parseFromArray($item));
				}
			}

			return $tagList;
		}

		/**
		 * @param Tag $tag
		 *
		 * @throws \ParameterError
		 */
		public static function CheckTagCreateArgs ($tag)
		{
			Utils::checkNotEmptyStr($tag->tagname, "tagname");
		}

		/**
		 * @param Tag $tag
		 *
		 * @throws \ParameterError
		 */
		public static function CheckTagUpdateArgs ($tag)
		{
			Utils::checkIsUInt($tag->tagid, "tagid");
			Utils::checkNotEmptyStr($tag->tagname, "tagname");
		}

		/**
		 * @param int   $tagId
		 * @param array $userIdList
		 * @param array $partyIdList
		 *
		 * @throws \ParameterError
		 * @throws \QyApiError
		 */
		public static function CheckTagADUserArgs ($tagId, $userIdList, $partyIdList)
		{
			Utils::checkIsUInt($tagId, "tagid");

			if (!Utils::notEmptyArray($userIdList) && !Utils::notEmptyArray($partyIdList)) {
				throw new \QyApiError("userIdList and partyIdList should not be both empty");
			}
		}

		/**
		 * @param int   $tagId
		 * @param array $userIdList
		 * @param array $partyIdList
		 *
		 * @return array
		 */
		public static function ToTagADUserArray ($tagId, $userIdList, $partyIdList)
		{
			$arr = [];

			Utils::setIfNotNull($tagId, "tagid", $arr);
			Utils::setIfNotNull($userIdList, "userlist", $arr);
			Utils::setIfNotNull($partyIdList, "partylist", $arr);

			return $arr;
		}
	}