<?php

namespace dmerten\ErrorHandler;

use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{

    public function testGetErrorCodeString()
    {
        $error = new Error('test', E_USER_WARNING, 1337, '1337.php', 'none');
        $this->assertSame('User Warning', $error->getErrorCodeString());
        $error = new Error('test', E_ERROR, 1337, '1337.php', 'none');
        $this->assertSame('Fatal Error', $error->getErrorCodeString());
    }

    public function testToString()
    {
        $error = new Error('test', E_ERROR, 1337, '1337.php', 'none');
        $this->assertSame('Fatal Error: test in 1337.php on line 1337', (string)$error);
    }
}
