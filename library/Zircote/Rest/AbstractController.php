<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package Zircote
 * @subpackage Controller
 *
 * - Method  URI                            Module_Controller::action
 * - GET     /v{?}/users/                   Api_UsersController::getAction()
 * - GET     /v{?}/users/:id                Api_UsersController::getAction()
 * - POST    /v{?}/users                    Api_UsersController::postAction()
 * - PUT     /v{?}/users/:id                Api_UsersController::putAction()
 * - GET     /v{?}/users/:id?_method=put    Api_UsersController::putAction()
 * - DELETE  /v{?}/users/:id                Api_UsersController::deleteAction()
 * - GET     /v{?}/users/:id?_method=delete Api_UsersController::deleteAction()
 */
abstract class Zircote_Rest_AbstractController extends Zend_Controller_Action
{
    protected $_attributes;
    /**
     *
     * @var array
     */
    protected $_options;
    /**
     *
     * @var Zircote_Rest_AbstractService
     */
    protected $_service;
    /**
     * Default Allow
     * @var array
     */
    protected $_allow = array('GET','POST','PUT','DELETE','OPTIONS','TRACE');

    /**
     *
     * @var Zend_Log
     */
    protected $_log;
    /**
     * @todo add support for config from Zend_Config
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init ()
    {
        /* @var $bootstrap Zend_Zircote_Rest_Bootstrap_Bootstrap */
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        if($bootstrap->hasResource('rest_controller')){
            $this->setOptions(
                $bootstrap->getResource('rest_controller')->getRestController()
            );
        }
    }
    /**
     *
     * @param array|Zend_Config $options
     * @return Zircote_Rest_AbstractController
     */
    public function setOptions($options)
    {
        if($options instanceof Zend_Config){
            $options = $options->toArray();
        }
        $this->_options = $options;
        return $this;
    }
    public function preDispatch()
    {
        $this->_helper->viewRenderer->setNoRender();
        if($this->_service instanceof Zircote_Rest_AbstractService){
            $this->_service->preDispatch();
        }
    }
    public function setService(Zircote_Rest_AbstractService $service)
    {
        $this->_service = $service;
        return $this;
    }
    public function postDispatch()
    {
        if($this->_service instanceof Zircote_Rest_AbstractService){
            $this->_service->postDispatch();
        }
    }
    /**
     *
     */
    public function notAllowedAction() {
        $this->getResponse()->setHttpResponseCode(405);
    }
    /**
     *
     */
    public final function indexAction() {
        return $this->__call('index',null);
    }
    /**
     *
     */
    public function getAction() {
        $this->notAllowedAction();
    }
    /**
     *
     */
    public function putAction() {
        $this->notAllowedAction();
    }
    /**
     *
     */
    public function postAction() {
        $this->notAllowedAction();
    }
    /**
     *
     */
    public function deleteAction() {
        $this->notAllowedAction();
    }
    /**
     *
     */
    public function headAction() {
        $this->notAllowedAction();
    }
    /**
     *
     */
    public function optionsAction() {
        $this->notAllowedAction();
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::__call()
     */
    public function __call($method, $args = array())
    {
        $reflected = new ReflectionClass($this);
        $method = $this->_service
            ->methodRequest() ? : $this->getRequest()->getMethod();
        $method = strtolower($method) . 'Action';
        if ($reflected->hasMethod($method)) {
            return $reflected->getMethod($method)
            ->invokeArgs($this,is_array($args) ? $args : array());
        }
        $this->notAllowedAction();
    }
    /**
     *
     * @return array
     */
    public function getParams()
    {
        return $this->getRequest()->getParams();
    }
    /**
     *
     * @return multitype:
     */
    public function getAllow()
    {
        return $this->_allow;
    }
}
