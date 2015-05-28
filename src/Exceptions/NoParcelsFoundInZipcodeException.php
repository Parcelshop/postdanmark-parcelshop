<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk\Exceptions;

/**
 * No parcels in zipcode exception
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class NoParcelsFoundInZipcodeException extends Exception
{

    /**
     * Construct no parcels found in zipcode exception
     *
     * @param string $zipcode
     */
    public function __construct($zipcode)
    {
        parent::__construct('No parcelshops found in "' . $zipcode . '"', 220);
    }
}
