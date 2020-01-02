<?php

	namespace dovechen\yii2\weWork\components;

	use yii\base\Object;

	/**
	 * Class WorkComponent
	 * @package dovechen\yii2\weWork\components
	 */
	class WorkComponent extends Object
	{
		/**
		 * @var BaseWork $work
		 */
		protected $work;

		/**
		 * WorkComponent constructor.
		 *
		 * @param BaseWork $work
		 * @param array    $config
		 */
		public function __construct (BaseWork $work, $config = [])
		{
			/** @var BaseWork work */
			$this->work = $work;

			parent::__construct($config);
		}
	}