<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk\Exceptions;

/**
 * Malformed address exception
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class MalformedAddressException extends Exception
{

    /**
     * Construct malformed address exception
     *
     * @param string $street
     * @param int $zip
     */
    public function __construct($street, $zip)
    {
        parent::__construct(sprintf('Address not known: %s, %s', $street, $zip), 230);
    }
}
