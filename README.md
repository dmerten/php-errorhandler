# PHP Errorhandler
Fancy customizable error handling for php errors.

## Usage
```php
include "vendor/autoload.php";

// Fancy logger for php error log files on webservers
$errorLog = new \dmerten\ErrorHandler\Publisher\ErrorLog($_SERVER, $_POST);

// Fancy logger for docker output / logging in docker environments
$stdErr = new \dmerten\ErrorHandler\Publisher\StdOut($_SERVER) 

// Format and log php errors with every instance of Publisher 
$publishers = [
    $errorLog,
    $stdErr
];
$handler = new \dmerten\ErrorHandler\ErrorHandler($publishers);

// register fancy handlers
set_error_handler([$handler, 'handleError']);
register_shutdown_function([$handler, 'handleShutdown']);
