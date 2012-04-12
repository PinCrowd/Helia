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
interface Zircote_Rest_JsonRenderableInterface
{
    /**
     * @return string
     */
    public function toJson();
}