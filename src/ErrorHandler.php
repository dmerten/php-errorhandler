<?php
/**
 *
 * @author Dirk Merten
 */

namespace dmerten\ErrorHandler;
use dmerten\ErrorHandler\Publisher\Publisher;


/**
 * Class ErrorHandler
 * @package dmerten\ErrorHandler
 */
class ErrorHandler
{
	/**
	 * @var Publisher[]
	 */
	private $publishers;

	/**
	 * @param Publisher[] $publisher
	 */
	public function __construct(array $publisher)
	{
		$this->publishers = $publisher;
	}

	/**
	 * @param $errorCode
	 * @param $errorMessage
	 * @param $file
	 * @param $line
	 */
	public function handleError($errorCode, $errorMessage, $file, $line)
	{
		$errorCode = $errorCode & error_reporting();
		if ($errorCode == 0) {
			return;
		}

		$stacktrace = $this->getStackTrace();
		$error = new Error($errorMessage, $errorCode, $line, $file, $stacktrace);

		$this->publish($error);
	}

	/**
	 * @return void
	 */
	public function handleShutdown()
	{
		$error = error_get_last();
		if ($this->isFatalError($error)) {
			$stacktrace = $this->getStackTrace();
			$error = new Error($error['message'], $error, $error['line'], $error['file'], $stacktrace);
			$this->publish($error);
		}
	}

	/**
	 * @return string
	 */
	private function getStackTrace()
	{
		$output = '';
		if (function_exists('debug_backtrace')) {
			$backtrace = debug_backtrace();
			array_shift($backtrace); // Handler
			array_shift($backtrace); // This function
			foreach ($backtrace as $i => $l) {
				if ($i == 0) {
					$output .= "\n";
				}

				$class = isset($l['class']) ? $l['class'] : '';
				$type = isset($l['type']) ? $l['type'] : '';
				$function = isset($l['function']) ? $l['function'] : '';

				$output .= "[$i] in function $class$type$function";
				if (isset($l['file'])) {
					$output .= " in {$l['file']}";
				}
				if (isset($l['line'])) {
					$output .= " on line {$l['line']}";
				}
				$output .= "\n";
			}
		}

		return $output;
	}

	/**
	 * @param $error
	 * @return bool
	 */
	private function isFatalError($error)
	{
		return isset($error['type']) && in_array($error['type'], array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR));
	}

	/**
	 * @param Error $error
	 */
	private function publish(Error $error)
	{
		foreach ($this->publishers as $publisher) {
			$publisher->publishError($error);
		}
	}
}


