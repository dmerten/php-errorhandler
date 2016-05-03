<?php
/**
 *
 * @author Dirk Merten
 */

namespace dmerten\ErrorHandler\Publisher;


use dmerten\ErrorHandler\Error;

class ErrorLog implements Publisher
{
	/**
	 * @var array
	 */
	private $server = [];
	/**
	 * @var array
	 */
	private $post = [];

	/**
	 * ErrorLog constructor.
	 * @param array $server
	 * @param array $post
	 */
	public function __construct(array $server, array $post)
	{
		$this->server = $server;
		$this->post = $post;
	}

	/**
	 * @param Error $error
	 * @return bool
	 */
	public function publishError(Error $error)
	{
		return error_log($this->getErrorTemplate((string) $error . $error->getStacktrace()));
	}

	/**
	 * @param $errorMessage
	 * @return string
	 */
	private function getErrorTemplate($errorMessage)
	{
		$output = '';

		if (!empty($this->server['REQUEST_URI'])) {
			$output .= "\nREQUEST: " .$this->server['REQUEST_URI'] . "\n";
		}

		$output .= $errorMessage;

		if (!empty($this->post)) {
			$output .= "POST: " . print_r($this->post, true);
		}

		return $output;
	}

}
