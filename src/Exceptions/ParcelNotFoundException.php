<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk\Exceptions;

/**
 * Parcel not found exception
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class ParcelNotFoundException extends Exception
{

    /**
     * Construct parcel not found exception
     *
     * @param string $parcelnumber
     */
    public function __construct($parcelnumber)
    {
        parent::__construct('Parcelshop "' . $parcelnumber . '" not found"', 210);
    }
}
