<?php

class V1_Game_GamesIdController extends Pincrowd_Rest_AbstractController
{
    /**
     *
     * @var string
     */
    protected $_baseUri = '/v1';
    /**
     *
     * @var string
     */
    protected $_resource = 'games';
    /**
     *
     * @var V1_Service_Game_Games
     */
    protected $_service;
    /**
     * Default Allow
     * @var array
     */
    protected $_allow = array('GET','POST', 'OPTIONS', 'HEAD');
    /**
     *
     * @see Pincrowd_Rest_AbstractController::init()
     */
    public function init()
    {
        parent::init();
        $this->setService(new V1_Service_Game_Game($this->_options, $this));
        /* @var $bootstrap Pincrowd_Rest_Bootstrap_Bootstrap */
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        if($bootstrap->hasResource('db')){
            $this->_service->getMapper()->setDb($bootstrap->getResource('db'));
        }
        if($bootstrap->hasResource('log')){
            $log = $bootstrap->getResource('log');
        }
    }
}