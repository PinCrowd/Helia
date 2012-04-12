<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage
 *
 *
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     *  Actions and contexts fpr contextSwitch helper
     * @var array
     */
    public $contexts = array(
        'error'  => array('json','xml')
    );
    public function init()
    {
        /* @var $cs Zend_Controller_Action_Helper_ContextSwitch */
        $cs = $this->_helper->contextSwitch();
        $cs->initContext();
        $cs->initContext($cs->getCurrentContext() ?: 'json');
        $cs->setAutoJsonSerialization(false);
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->getResponse()->setHttpResponseCode(500);
            $this->result['message'] = 'You have reached the error page';
            $this->result['code'] = 400;
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->result['message'] = 'Page not found';
                $this->result['code'] = 404;
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->result['message'] = 'Application error';
                $this->result['code'] = 500;
                $this->result['error'] = $errors;
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->result['exception'] = $errors->exception;
        }

        $this->result['request']   = $errors->request;
        $this->getResponse()->setHeader('Content-Type', 'application/json', 1);
        $this->getResponse()->appendBody(Zend_Json::encode($this->result));
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

