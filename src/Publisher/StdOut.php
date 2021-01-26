<?php


namespace dmerten\ErrorHandler\Publisher;


use dmerten\ErrorHandler\Error;

class StdOut implements Publisher
{
    /**
     * $_SERVER
     * @var array
     */
    private $server = [];

    /**
     * StdOut constructor.
     * @param array $server
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }


    /**
     * Preformatted for logststash / kibana usage (filters etc)
     * @param Error $error
     * @return void
     */
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
