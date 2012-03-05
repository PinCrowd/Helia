<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package
 * @subpackage
 *
 *
 */
abstract class Zircote_Service_RestServiceAbstract extends Zircote_Service_ServiceAbstract
{
    protected $_sortingHelper;
    protected $_pagingHelper;
    /**
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest()
    {
        return Zend_Controller_Front::getInstance()->getRequest();
    }
    /**
     * @return Zend_Controller_Response_Abstract
     */
    public function getResponse()
    {
        return Zend_Controller_Front::getInstance()->getResponse();
    }
    public function setPagingHelper(Zircote_Controller_Action_Helper_RestPaging $pagingHelper)
    {
        $this->_pagingHelper = $pagingHelper;
        return $this;
    }
    public function setSortingHelper(Zircote_Controller_Action_Helper_RestSorting $sortingHelper)
    {
        $this->_sortingHelper = $sortingHelper;
        return $this;
    }
}