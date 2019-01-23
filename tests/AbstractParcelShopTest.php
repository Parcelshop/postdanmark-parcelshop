<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Lsv\PdDk\Client;

abstract class AbstractParcelShopTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param MockHandler $mock
     * @return Client
     */
    protected function getParser(MockHandler $mock = null)
    {
        return new Client('', '', $this->getClient($mock));
    }

    protected function getReturnJson($xmlfile)
    {
        return file_get_contents(__DIR__ . '/jsonreturn/' . $xmlfile);
    }

    protected function getClient(MockHandler $mock = null)
    {
        $client = new HttpClient();
        if ($mock) {
            $handler = HandlerStack::create($mock);
            $client = new HttpClient(['handler' => $handler]);
        }

        return $client;
    }

    protected function getExceptionNamespace($exception)
    {
        return sprintf('Lsv\PdDk\Exceptions\%s', $exception);
    }
}
