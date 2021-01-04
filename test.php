<?php
/**
 *
 * @author Dirk Merten
 */
include "vendor/autoload.php";

$publishers = [
    new \dmerten\ErrorHandler\Publisher\ErrorLog($_SERVER, $_POST),
    new \dmerten\ErrorHandler\Publisher\StdOut($_SERVER)
];

$handler = new \dmerten\ErrorHandler\ErrorHandler($publishers);
set_error_handler([$handler, 'handleError']);


function foo() {
	return bar();
}

function bar() {
	return 10 / 0;
}

echo foo();
