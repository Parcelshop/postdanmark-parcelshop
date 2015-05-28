<?php
/**
 * This file is part of the Lsv\GlsDk
 */
namespace Lsv\PdDk\Entity;

/**
 * Opening entity, holds openings for a parcelshop
 *
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
class Opening
{

    /**
     * The day of the opening
     * One of either: 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
     *
     * @var string
     */
    protected $day;

    /**
     * The clock its open from
     *
     * @var string
     */
    protected $openFrom;

    /**
     * The clock its closing
     *
     * @var string
     */
    protected $openTo;

    /**
     * Gets the Day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Sets the Day
     *
     * @param string $day
     * @return Opening
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * Gets the From
     *
     * @return string
     */
    public function getOpenFrom()
    {
        return $this->openFrom;
    }

    /**
     * Sets the From
     *
     * @param string $openFrom
     * @return Opening
     */
    public function setOpenFrom($openFrom)
    {
        $this->openFrom = $openFrom;
        return $this;
    }

    /**
     * Gets the To
     *
     * @return string
     */
    public function getOpenTo()
    {
        return $this->openTo;
    }

    /**
     * Sets the To
     *
     * @param string $openTo
     * @return Opening
     */
    public function setOpenTo($openTo)
    {
        $this->openTo = $openTo;
        return $this;
    }
}
