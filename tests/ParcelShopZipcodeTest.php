<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class ParcelShopZipcodeTest extends AbstractParcelShopTest
{

    public function testGetParcelsFromZipcodeZipcodeNotFound()
    {
        $this->setExpectedException($this->getExceptionNamespace('NoParcelsFoundInZipcodeException'), '', 220);
        $mock = new Mock([
            new Response(400)
        ]);
        $this->getParser($mock)->getParcelshopsFromZipcode(1000);
    }

    public function testGetParcelsFromZipcode()
    {
        $mock = new Mock([
            new Response(200, [], Stream::factory($this->getReturnJson('parcelszipcode.json')))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsFromZipcode(1000);
        $this->assertCount(5, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf('Lsv\PdDk\Entity\Parcelshop', $parcel);
        }

    }

    public function testSetLimit()
    {
        $mock = new Mock([
            new Response(200, [], Stream::factory($this->getReturnJson('parcelszipcode_limit1.json')))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsFromZipcode(1000, 1);
        $this->assertCount(1, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf('Lsv\PdDk\Entity\Parcelshop', $parcel);
        }
    }
}
