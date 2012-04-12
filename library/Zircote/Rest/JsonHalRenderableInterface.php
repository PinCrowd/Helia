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
interface Zircote_Rest_JsonHalRenderableInterface
{
    /**
     * @return string
     */
    public function toJsonHal($baseUri = null);
}