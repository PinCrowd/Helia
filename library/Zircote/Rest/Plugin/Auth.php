<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package
 * @subpackage
 *
 *
 */
class Zircote_Rest_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    /**
     * (non-PHPdoc)
     * @see Zircote_Rest_Plugin_RestAbstract::setOptions()
     */
    public function setOptions($options)
    {
        $this->_defaults = $options;
        return $this;
    }
    public function preDispatch($request)
    {
    }
}