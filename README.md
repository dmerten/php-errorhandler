# PHP Errorhandler
Fancy customizable error handling for php errors.

## Usage
```php
include "vendor/autoload.php";

$publishers[] = new \dmerten\ErrorHandler\Publisher\ErrorLog($_SERVER, $_POST);
$handler = new \dmerten\ErrorHandler\ErrorHandler($publishers);

// register fancy handler
set_error_handler([$handler, 'handleError']);
register_shutdown_function([$handler, 'handleShutdown']);
