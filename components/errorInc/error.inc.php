<?php

	/**
	 * Class SysError
	 */
	class SysError extends Exception
	{
		/**
		 * SysError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}

	/**
	 * Class ParameterError
	 */
	class ParameterError extends Exception
	{
		/**
		 * ParameterError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}

	/**
	 * Class NetWorkError
	 */
	class NetWorkError extends Exception
	{
		/**
		 * NetWorkError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}

	/**
	 * Class HttpError
	 */
	class HttpError extends Exception
	{
		/**
		 * HttpError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}

	/**
	 * Class QyApiError
	 */
	class QyApiError extends Exception
	{
		/**
		 * QyApiError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}

	/**
	 * Class InternalError
	 */
	class InternalError extends Exception
	{
		/**
		 * InternalError constructor.
		 *
		 * @inheritDoc
		 *
		 * @param                $message
		 * @param int            $code
		 * @param Exception|NULL $previous
		 */
		public function __construct ($message, $code = 0, Exception $previous = NULL)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @return string
		 */
		public function __toString ()
		{
			return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		}
	}