<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Lsv\PdDk\ParcelShop;

abstract class AbstractParcelShopTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param MockHandler $mock
     * @return ParcelShop
     */
    protected function getParser(MockHandler $mock = null)
    {
        return new ParcelShop('', '', $this->getClient($mock));
    }

    protected function getReturnJson($xmlfile)
    {
        return file_get_contents(__DIR__ . '/jsonreturn/' . $xmlfile);
    }

    protected function getClient(MockHandler $mock = null)
    {
        $client = new Client();
        if ($mock) {
            $handler = HandlerStack::create($mock);
            $client = new Client(['handler' => $handler]);
        }

        return $client;
    }

    protected function getExceptionNamespace($exception)
    {
        return sprintf('Lsv\PdDk\Exceptions\%s', $exception);
    }
}
