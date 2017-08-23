<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lsv\PdDk\Entity\Parcelshop;

class ParcelShopAddressTest extends AbstractParcelShopTest
{

    public function testGetNearstParcelWrongAddress()
    {
        $this->expectException($this->getExceptionNamespace('MalformedAddressException'));
        $this->expectExceptionCode(230);

        $mock = new MockHandler([
            new Response(400)
        ]);
        $this->getParser($mock)->getParcelshopsNearAddress('unknown address', 10000);
    }

    public function testGetNearstParcel()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('parcelszipcode.json'))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsNearAddress('correct address', 1000);
        $this->assertCount(5, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf(Parcelshop::class, $parcel);
        }
    }
}
