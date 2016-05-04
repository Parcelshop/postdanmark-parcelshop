<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class ParcelShopAddressTest extends AbstractParcelShopTest
{

    public function testGetNearstParcelWrongAddress()
    {
        $this->setExpectedException($this->getExceptionNamespace('MalformedAddressException'), '', 230);

        $mock = new Mock([
            new Response(400)
        ]);

        $this->getParser($mock)->getParcelshopsNearAddress('unknown address', 10000);
    }

    public function testGetNearstParcel()
    {
        $mock = new Mock([
            new Response(200, [], Stream::factory($this->getReturnJson('parcelszipcode.json')))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsNearAddress('correct address', 1000);
        $this->assertCount(5, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf('Lsv\PdDk\Entity\Parcelshop', $parcel);
        }
    }
}
