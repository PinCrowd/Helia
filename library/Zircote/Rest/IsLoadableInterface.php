<?php
/**
 *
 *
 * @category   Zircote
 * @package    Zircote_Rest
 * @subpackage Controller
 */

/**
 *
 * @category   Zircote
 * @package    Zircote_Rest
 * @subpackage Controller
 */
interface Zircote_Rest_IsLoadableInterface
{

    /**
     * @return boolean
     */
    public function isLoaded();
    /**
     *
     * @param boolean $loaded
     */
    public function setIsLoaded($loaded);
}