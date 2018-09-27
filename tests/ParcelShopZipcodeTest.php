<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lsv\PdDk\Entity\Parcelshop;

class ParcelShopZipcodeTest extends AbstractParcelShopTest
{

    public function testGetParcelsFromZipcodeZipcodeNotFound()
    {
        $this->expectException($this->getExceptionNamespace('NoParcelsFoundInZipcodeException'));
        $this->expectExceptionCode(220);
        $mock = new MockHandler([
            new Response(400)
        ]);
        $this->getParser($mock)->getParcelshopsFromZipcode(1000);
    }

    public function testGetParcelsFromZipcode()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('parcelszipcode.json'))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsFromZipcode(1000);
        $this->assertCount(5, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf(Parcelshop::class, $parcel);
        }
    }

    public function testSetLimit()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('parcelszipcode_limit1.json'))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsFromZipcode(1000, 1);
        $this->assertCount(1, $parcels);
        foreach ($parcels as $parcel) {
            $this->assertInstanceOf(Parcelshop::class, $parcel);
        }
    }

    public function testSwedishParcels()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('swedish_zipcode.json'))
        ]);

        $parcels = $this->getParser($mock)->getParcelshopsFromZipcode(21573);
        $this->assertCount(5, $parcels);
        foreach ($parcels as $num => $parcel) {
            $this->assertInstanceOf(Parcelshop::class, $parcel);
            if ($num === 0) {
                $this->assertSame('Munkhättegatan', $parcel->getStreetname());
                $this->assertSame('21559', $parcel->getZipcode());
                $this->assertSame('MALMÖ', $parcel->getCity());
            }
        }
    }
}
