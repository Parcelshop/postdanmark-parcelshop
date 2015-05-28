<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Parcelshop entity, holds a parcelshop data
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class Parcelshop
{

    /**
     * GLS parcelshop ID
     *
     * @var string
     */
    private $number;

    /**
     * Company name of the parcelshop
     *
     * @var string
     */
    private $companyname;

    /**
     * Streetname of the parcelshop
     *
     * @var string
     */
    private $streetname;

    /**
     * Additional street of the parcelshop
     *
     * @var string
     */
    private $streetname2;

    /**
     * Zipcode of the parcelshop
     *
     * @var string
     */
    private $zipcode;

    /**
     * City of the parcelshop
     *
     * @var string
     */
    private $city;

    /**
     * Country code of the parcelshop
     * GLS own country codes, not ISO 3166-1 numbers
     *
     * @var string
     */
    private $countrycode;

    /**
     * Country isocode, using ISO 3166-1 alpha-2
     * @var string
     */
    private $countrycode_iso;

    /**
     * Phone number of the parcelshop
     *
     * @var string
     */
    private $telephone;

    /**
     * GPS Coordinates of the parcelshop
     *
     * @var string
     */
    private $coordinate;

    /**
     * Openings for the parcelshop
     *
     * @var Opening[]|ArrayCollection
     */
    private $openings;

    /**
     * Construct parcelshop entity
     */
    public function __construct()
    {
        $this->openings = new ArrayCollection();
    }

    /**
     * Gets the City
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the City
     *
     * @param string $city
     * @return Parcelshop
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Gets the Companyname
     *
     * @return string
     */
    public function getCompanyname()
    {
        return $this->companyname;
    }

    /**
     * Sets the Companyname
     *
     * @param string $companyname
     * @return Parcelshop
     */
    public function setCompanyname($companyname)
    {
        $this->companyname = $companyname;
        return $this;
    }

    /**
     * Gets the Countrycode
     *
     * @return string
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * Sets the Countrycode
     *
     * @param string $countrycode
     * @return Parcelshop
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;
        return $this;
    }

    /**
     * Gets the CountrycodeIso
     *
     * @return string
     */
    public function getCountrycodeIso()
    {
        return $this->countrycode_iso;
    }

    /**
     * Sets the CountrycodeIso
     *
     * @param string $countrycode_iso
     * @return Parcelshop
     */
    public function setCountrycodeIso($countrycode_iso)
    {
        $this->countrycode_iso = $countrycode_iso;
        return $this;
    }

    /**
     * Gets the Number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the Number
     *
     * @param string $number
     * @return Parcelshop
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Gets the Streetname
     *
     * @return string
     */
    public function getStreetname()
    {
        return $this->streetname;
    }

    /**
     * Sets the Streetname
     *
     * @param string $streetname
     * @return Parcelshop
     */
    public function setStreetname($streetname)
    {
        $this->streetname = $streetname;
        return $this;
    }

    /**
     * Gets the Streetname2
     *
     * @return string
     */
    public function getStreetname2()
    {
        return $this->streetname2;
    }

    /**
     * Sets the Streetname2
     *
     * @param string $streetname2
     * @return Parcelshop
     */
    public function setStreetname2($streetname2)
    {
        $this->streetname2 = $streetname2;
        return $this;
    }

    /**
     * Gets the Telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Sets the Telephone
     *
     * @param string $telephone
     * @return Parcelshop
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Gets the Zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Sets the Zipcode
     *
     * @param string $zipcode
     * @return Parcelshop
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * Add single opening
     *
     * @param Opening $openings
     * @return Parcelshop
     */
    public function addOpening(Opening $openings)
    {
        $this->openings[] = $openings;
        return $this;
    }

    /**
     * Set all openings at once
     *
     * @param array $openings
     * @return Parcelshop
     */
    public function setOpenings(array $openings)
    {
        $this->openings = new ArrayCollection();
        foreach ($openings as $opening) {
            $this->addOpening($opening);
        }
        return $this;
    }

    /**
     * Get openings
     *
     * @return Opening[]
     */
    public function getOpenings()
    {
        return $this->openings;
    }

    /**
     * Gets the Coordinate
     *
     * @return string
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * Sets the Coordinate
     *
     * @param float $longitude
     * @param float $latitude
     * @return Parcelshop
     */
    public function setCoordinate($longitude, $latitude)
    {
        $this->coordinate = sprintf('%s,%s', $longitude, $latitude);
        return $this;
    }
}
