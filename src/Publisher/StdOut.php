<?php


namespace dmerten\ErrorHandler\Publisher;


use dmerten\ErrorHandler\Error;

class StdOut implements Publisher
{
    private $server = [];

    /**
     * StdOut constructor.
     * @param array $server
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }


    public function publishError(Error $error)
    {
        fwrite(
            fopen('php://stderr', 'w'),
            json_encode(
                ['php' => [
                    'time' => new \DateTime(),
                    'msg' => (string)$error,
                    'stacktrace' => $error->getStacktrace(),
                    'filename' => $error->getFileName(),
                    'type' => $error->getErrorCodeString(),
                    'request' => $this->server['REQUEST_URI'] ?? 'not set'
                ]]
            ) . PHP_EOL);

    }

}
