<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @category   Zircote
 * @package    Zircote_Rest
 * @subpackage Controller
 */
/**
 *
 *
 */
interface Zircote_Rest_LastUpdatedInterface
{
    /**
     * @return string
     */
    public function getLastUpdated();
    /**
     * @return string
     */
    public function getLastUpdatedField();
}