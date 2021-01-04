<?php
/**
 *
 * @author Dirk Merten
 */

namespace dmerten\ErrorHandler;


/**
 * Class Error
 * @package dmerten\ErrorHandler
 */
class Error
{
	/**
	 * @var int
	 */
	private $errorCode = 0;
	/**
	 * @var string
	 */
	private $errorMessage = '';
	/**
	 * @var int
	 */
	private $line = 0;
	/**
	 * @var string
	 */
	private $fileName = '';
	/**
	 * @var string
	 */
	private $stackTrace = '';

	/**
	 * @param $errorMessage
	 * @param $errorCode
	 * @param $line
	 * @param $fileName
	 * @param $stackTrace
	 */
	public function __construct($errorMessage, $errorCode, $line, $fileName, $stackTrace)
	{
		$this->errorMessage = $errorMessage;
		$this->errorCode = $errorCode;
		$this->line = $line;
		$this->fileName = $fileName;
		$this->stackTrace = $stackTrace;
	}

	/**
	 * @return string
	 */
	public function getErrorCodeString()
	{
		switch ($this->errorCode) {
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
				$message = "Fatal Error";
				break;
			case E_WARNING:
				$message = "Warning";
				break;
			case E_NOTICE:
				$message = "Notice";
				break;
			case E_USER_ERROR:
				$message = "User Error";
				break;
			case E_USER_WARNING:
				$message = "User Warning";
				break;
			case E_USER_NOTICE:
				$message = "User Notice";
				break;
			case E_STRICT:
				$message = "Strict Notice";
				break;
			case E_RECOVERABLE_ERROR:
				$message = "Recoverable Error";
				break;
			default:
				$message = "Unknown error ({$this->errorCode})";
				break;
		}
		return $message;
	}

	public function __toString()
	{
		return  $this->getErrorCodeString() . ": {$this->errorMessage} in {$this->fileName} on line {$this->line}";
	}

	/**
	 * @return string
	 */
	public function getStacktrace()
	{
		return $this->stackTrace;
	}

}
