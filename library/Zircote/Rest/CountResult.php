<?php
/**
 * @category   Zircote
 * @package    Zircote_Rest
 * @subpackage Model
 */
/**
 * @category   Zircote
 * @package    Zircote_Rest
 * @subpackage Model
 */
class Zircote_Rest_CountResult extends Zircote_Model_AbstractModel
{
    /**
     *
     * @var string
     */
    protected $_halRel = 'count';
    /**
     *
     * @var string
     */
    protected $_halResource = '/leadresponder/count';
    /**
     *
     * @var array
     */
    protected $_types = array('count' => 'int');
    /**
     *
     * @var array
     */
    protected $_params = array('count' => 0);
}
