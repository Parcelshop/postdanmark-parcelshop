<?php
namespace Lsv\PdDkTest;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lsv\PdDk\Entity\Parcelshop;

class ParcelShopSingleTest extends AbstractParcelShopTest
{

    public function testOneParcelNotFound()
    {
        $this->expectException($this->getExceptionNamespace('ParcelNotFoundException'));
        $this->expectExceptionCode(210);

        $mock = new MockHandler([
            new Response(400)
        ]);

        $this->getParser($mock)->getParcelshop(1000, 'unknown');
    }

    public function testOneParcelFound()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('parcelszipcode.json'))
        ]);

        $parcel = $this->getParser($mock)->getParcelshop(1000, 376);

        $this->assertInstanceOf(Parcelshop::class, $parcel);
        $this->assertEquals('376', $parcel->getNumber());
        $this->assertEquals('Pakkeboks 376 Fakta', $parcel->getCompanyname());
        $this->assertEquals('RINGSTED', $parcel->getCity());
        $this->assertEquals('DK', $parcel->getCountrycode());
        $this->assertEquals('DK', $parcel->getCountrycodeIso());
        $this->assertEquals('Jyllandsgade 11', $parcel->getStreetname());
        $this->assertNull($parcel->getStreetname2());
        $this->assertEquals('', $parcel->getTelephone());
        $this->assertEquals('4100', $parcel->getZipcode());
        $this->assertEquals('55.442315,11.787644', $parcel->getCoordinate());
        $this->assertCount(7, $parcel->getOpenings());

        foreach ($parcel->getOpenings() as $opening) {
            $this->assertContains(
                $opening->getDay(),
                ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            );
            $this->assertEquals('08:00', $opening->getOpenFrom());
            $this->assertEquals('22:00', $opening->getOpenTo());
        }
    }

    public function testFindOneParcelParcelsFoundButNotCorrect()
    {
        $this->expectException($this->getExceptionNamespace('ParcelNotFoundException'));
        $this->expectExceptionCode(210);

        $mock = new MockHandler([
            new Response(200, [], $this->getReturnJson('parcelszipcode.json'))
        ]);

        $this->getParser($mock)->getParcelshop(1000, 999);
    }
}
