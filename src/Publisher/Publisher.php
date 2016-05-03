<?php
/**
 *
 * @author Dirk Merten
 */

namespace dmerten\ErrorHandler\Publisher;


use dmerten\ErrorHandler\Error;

/**
 * Interface Publisher
 * @package dmerten\ErrorHandler\Publisher
 */
interface Publisher
{
	/**
	 * @param Error $error
	 * @return mixed
	 */
	public function publishError(Error $error);
}
