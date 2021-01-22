<?php


use dmerten\ErrorHandler\ErrorHandler;
use PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{

    public function testHandleErrorPublish()
    {

        $publisher = $this->getMockBuilder('dmerten\ErrorHandler\Publisher\Errorlog')->disableOriginalConstructor()->getMock();
        $publisher->expects($this->once())->method('publishError');
        $handler = new dmerten\ErrorHandler\ErrorHandler([$publisher]);
        $handler->handleError(E_WARNING, 'warning', '1337.php', 1337);
    }
}
