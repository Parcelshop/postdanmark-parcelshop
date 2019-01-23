<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Lsv\PdDk\Entity;
use Lsv\PdDk\Exceptions\MalformedAddressException;
use Lsv\PdDk\Exceptions\NoParcelsFoundInZipcodeException;
use Lsv\PdDk\Exceptions\ParcelNotFoundException;

/**
 * Client
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class Client
{
    /**
     * Webservice url
     *
     * @var string
     */
    const WEBSERVICE = 'api2.postnord.com/rest/businesslocation/v1/servicepoint';

    /**
     * HTTP URL
     *
     * @var string
     */
    private $url;

    /**
     * HTTP client
     *
     * @var Client
     */
    private $client;

    /**
     * Selected country
     *
     * @var string
     */
    private $country;

    /**
     * Your api key
     *
     * @var string
     */
    private $apiKey;

    /**
     * @var bool
     */
    private $useSandbox = false;

    /**
     * Construct parcel
     *
     * @param string $apiKey
     * @param string $country
     * @param HttpClient $client
     * @param string $url
     */
    public function __construct($apiKey, $country = 'DK', HttpClient $client = null, $url = self::WEBSERVICE)
    {
        $this->apiKey = $apiKey;
        $this->setCountry($country);
        $this->client = $client ?: new HttpClient();
        $this->url = $url;
    }

    /**
     * @param string $country
     */
    public function setCountry($country = 'DK')
    {
        $this->country = $country;
    }

    /**
     * @param boolean $useSandbox
     */
    public function setUseSandbox($useSandbox)
    {
        $this->useSandbox = $useSandbox;
    }

    /**
     * Get parcelshop from ID and zipcode
     *
     * @param string $zipcode
     * @param int    $parcelnumber
     *
     * @return Entity\Parcelshop
     * @throws Exceptions\ParcelNotFoundException
     */
    public function getParcelshop($zipcode, $parcelnumber)
    {
        try {
            $parcels = $this->getParcelshopsFromZipcode($zipcode);
            foreach ($parcels as $parcel) {
                if ($parcel->getNumber() === (int)$parcelnumber) {
                    return $parcel;
                }
            }
            throw new ParcelNotFoundException($parcelnumber);
        } catch (NoParcelsFoundInZipcodeException $npfe) {
            throw new ParcelNotFoundException($parcelnumber);
        } catch (ClientException $e) {
            throw new ParcelNotFoundException($parcelnumber);
        }
    }

    /**
     * Get parcels from zipcode
     *
     * @param string $zipcode
     * @param null|int $limit
     *
     * @return Entity\Parcelshop[]
     * @throws Exceptions\NoParcelsFoundInZipcodeException
     */
    public function getParcelshopsFromZipcode($zipcode, $limit = null)
    {
        $url = 'findNearestByAddress.json';
        $params = [
            'postalCode' => $this->parseZipcode($zipcode),
        ];

        if (is_int($limit)) {
            $params['numberOfServicePoints'] = $limit;
        }

        try {
            return $this->getParcels($url, $params);
        } catch (ClientException $e) {
            throw new NoParcelsFoundInZipcodeException($this->parseZipcode($zipcode));
        }
    }

    /**
     * Get nearest parcels from a address
     *
     * @param string $street
     * @param string $zipcode
     * @param null|int $limit
     *
     * @return Entity\Parcelshop[]
     * @throws Exceptions\MalformedAddressException
     */
    public function getParcelshopsNearAddress($street, $zipcode, $limit = null)
    {
        $url = 'findNearestByAddress.json';
        $params = [
            'streetName' => $street,
            'postalCode' => $this->parseZipcode($zipcode),
        ];

        if (is_int($limit)) {
            $params['numberOfServicePoints'] = $limit;
        }

        try {
            return $this->getParcels($url, $params);
        } catch (ClientException $e) {
            throw new MalformedAddressException($street, $this->parseZipcode($zipcode));
        }
    }

    /**
     * @param string $zipcode
     *
     * @return string
     */
    private function parseZipcode($zipcode)
    {
        return preg_replace('/\D/', '', $zipcode);
    }

    /**
     * Generate parcels
     *
     * @param string $url
     * @param array $params
     *
     * @return Entity\Parcelshop[]
     * @throws ClientException
     */
    private function getParcels($url, array $params)
    {
        $url = $this->generateUrl($url, $params);
        try {
            $request = $this->client->get($url);
            return $this->generateParcels(\GuzzleHttp\json_decode($request->getBody(), true));
        } catch (ClientException $e) {
            throw $e;
        }
    }

    /**
     * Generate the url to the api with params
     *
     * @param string $url
     * @param array $params
     *
     * @return string
     */
    private function generateUrl($url, array $params)
    {
        $params['apikey'] = $this->apiKey;
        $params['countryCode'] = $this->country;
        $query = http_build_query($params);
        return sprintf(
            '%s/%s?%s',
            'https://' . ($this->useSandbox ? 'at' : '') . $this->url,
            $url,
            $query
        );
    }

    /**
     * Parse parcels from json data
     *
     * @param array $data
     *
     * @return Entity\Parcelshop[]
     */
    private function generateParcels(array $data)
    {
        $shops = [];
        if (isset($data['servicePointInformationResponse']['servicePoints'])) {
            foreach ($data['servicePointInformationResponse']['servicePoints'] as $shop) {
                $streetName = $shop['deliveryAddress']['streetName'];
                if (isset($shop['deliveryAddress']['streetNumber'])) {
                    $streetName .= ' ' . $shop['deliveryAddress']['streetNumber'];
                }

                $parcel = new Entity\Parcelshop();
                $parcel
                    ->setNumber((int)$shop['servicePointId'])
                    ->setCompanyname($shop['name'])
                    ->setStreetname($streetName)
                    ->setZipcode($shop['deliveryAddress']['postalCode'])
                    ->setCity($shop['deliveryAddress']['city'])
                    ->setCountrycode($shop['deliveryAddress']['countryCode'])
                    ->setCountrycodeIso($shop['deliveryAddress']['countryCode'])
                ;

                if (isset($shop['coordinate']['northing'], $shop['coordinate']['easting'])) {
                    $parcel->setCoordinate($shop['coordinate']['northing'], $shop['coordinate']['easting']);
                }

                if (isset($shop['openingHours'])) {
                    $parcel->setOpenings($this->parseOpenings($shop['openingHours']));
                }

                $shops[] = $parcel;
            }
        }

        return $shops;
    }

    /**
     * Parse openings from json data
     *
     * @param array $data
     * @return Entity\Opening[]
     */
    private function parseOpenings(array $data)
    {
        $openings = [];
        foreach ($data as $d) {
            $open = new Entity\Opening();
            $open
                ->setDay($this->parseOpeningDay($d['day']))
                ->setOpenFrom($this->parseTime($d['from1']))
                ->setOpenTo($this->parseTime($d['to1']));
            $openings[] = $open;
        }
        return $openings;
    }

    /**
     * Convert time to time format
     * @param string $time
     * @return string
     */
    private function parseTime($time)
    {
        $time = sprintf(
            '%d%d:%d%d',
            $time{0},
            $time{1},
            $time{2},
            $time{3}
        );
        return $time;
    }

    /**
     * Parse opening day string
     *
     * @param string $daystring
     * @return string
     */
    private function parseOpeningDay($daystring)
    {
        switch ($daystring) {
            case 'MO':
                return 'Monday';
            case 'TU':
                return 'Tuesday';
            case 'WE':
                return 'Wednesday';
            case 'TH':
                return 'Thursday';
            case 'FR':
                return 'Friday';
            case 'SA':
                return 'Saturday';
            case 'SU':
                return 'Sunday';
        }
        return '';
    }
}
