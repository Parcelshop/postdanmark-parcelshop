<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Lsv\PdDk\ParcelShop;

abstract class AbstractParcelShopTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param Mock $mock
     * @return ParcelShop
     */
    protected function getParser(Mock $mock = null)
    {
        return new ParcelShop('', '', $this->getClient($mock));
    }

    protected function getReturnJson($xmlfile)
    {
        return file_get_contents(__DIR__ . '/jsonreturn/' . $xmlfile);
    }

    protected function getClient(Mock $mock = null)
    {
        $client = new Client();

        if ($mock) {
            $client->getEmitter()->attach($mock);
        }

        return $client;
    }

    protected function getExceptionNamespace($exception)
    {
        return sprintf('Lsv\PdDk\Exceptions\%s', $exception);
    }

}
