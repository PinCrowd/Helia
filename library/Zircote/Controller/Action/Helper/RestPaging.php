<?php
/**
 *
 * @author zircote
 * @version
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';
/**
 * RestPaging Action Helper
 *
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zircote_Controller_Action_Helper_RestPaging extends Zend_Controller_Action_Helper_Abstract
{
    /**
     *
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    /**
     * Constructor: initialize plugin loader
     *
     * @return void
     */
    public function __construct ()
    {
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        // TODO Auto-generated 'direct' method
    }
}
