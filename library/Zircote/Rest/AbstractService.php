<?php

abstract class Zircote_Rest_AbstractService
{
    /**
     * Define the Mapper Class name to be utlized by this service
     *
     * @var string
     */
    protected $_mapperClass;
    /**
     * Mapper class
     *
     * @var Zircote_Model_Mapper_AbstractDbMapper
     */
    protected $_mapper;
    /**
     *
     * @var array
     */
    protected $_attributes = array();
    /**
     *
     * @var array
     */
    protected $_options;
    /**
     * @var Zircote_Rest_AbstractController
     */
    public $_controller;
    /**
     *
     * @var array
     */
    protected $_defaultOptions = array(
        'accept'          => array(
            'enabled' => true,
            'stackindex' => array(
                'post' => 10
            ),
            'defaults' => array(
                'types' => array(
                    'json' => array('type' => 'application/json'),
                    'json-p' => array(
                        'type' => 'application/json-p'),
                    'xml' => array(
                        'type' => 'application/xml',
                        'q' => '0.3'
                    )
                )
            )
        ),
        'allow'          => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 55
            ),
        ),
        'enforceTrailing' => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 5
            ),
        ),
        'fields'          => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 15
            ),
        ),
        'jsonp'           => array(
            'enabled' => true,
            'stackindex' => array(
                'post' => 15
            ),
        ),
        'lastUpdated'     => array(
            'enabled' => true,
            'stackindex' => array(
                'post' => 20
            ),
        ),
        'method' => array(
            'enabled' => true
        ),
        'logging'         => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 20
            ),
        'enabled' => false,
            'format' => "METHOD:[%%METHOD%%] PATHINFO:[%%PATHINFO%%] PARAMS:[%%PARAMS%%]"
        ),
        'paging'          => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 25,
                'post' => 25
            ),
        'defaults' => array(
            'limit' => 20,
            'offset' => 0
            )
        ),
        'search'          => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 30
            ),
        'searchKey' => 'q'
        ),
        'sort'            => array(
            'enabled' => true,
            'stackindex' => array(
                'pre' => 35
            ),
        ),
        'auth' => array(
            'enabled' => true,
            'identityKey' => 'acct_id'
        )
    );
    public function __construct($options, Zircote_Rest_AbstractController $controller)
    {
        $this->setOptions($options)
            ->setController($controller);
    }
    /**
     *
     * @return Zircote_Model_Mapper_AbstractDbMapper
     */
    public function getMapper()
    {
        if(!$this->_mapper instanceof Zircote_Model_Mapper_AbstractDbMapper
            && $this->_mapperClass){
            $reflected = new ReflectionClass($this->_mapperClass);
            $this->_mapper = $reflected->newInstance();
            $this->_mapper->setAttributes($this->getAttributes());
        }
        return $this->_mapper;
    }
    /**
     *
     * @param Zircote_Rest_AbstractController $controller
     * @return Zircote_Rest_AbstractService
     */
    public function setController(Zircote_Rest_AbstractController $controller)
    {
        $this->_controller = $controller;
        return $this;
    }
    /**
     *
     * @param Zend_Config|array $options
     */
    public function setOptions($options = array())
    {
        if($options instanceof Zend_Config){
            $options = $options->toArray();
        }
        $this->_options = array_merge_recursive(
            $this->_defaultOptions, is_array($options) ? $options: array()
        );
        return $this;
    }
    /**
     *
     * @param string $option
     */
    public function getOptions()
    {
        if(!$this->_options){
            $this->setOptions();
        }
        return $this->_options;
    }
    /**
     *
     * @param string $option
     */
    public function getOption($option)
    {
        if(!$this->_options){
            $this->setOptions();
        }
        return @$this->_options[$option] ? : false;
    }
    /**
     *
     * @param array $attr
     * @return Zircote_Rest_AbstractService
     */
    public function setAttributes($attr){
        $this->_attributes = $attr;
        return $this;
    }
    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::preDispatch()
     */
    public function preDispatch()
    {
        $pd = array();
        $reflected = new ReflectionClass($this);
        foreach ($this->getOptions() as $key => $value) {
            $method = "_{$key}PreDispatch";
            if($reflected->hasMethod($method)){
                $pd[@$value['stackindex']['pre'] ?: null] = $method;
            }
        }
        foreach ($pd as $method) {
            $_method = $reflected->getMethod($method);
            $_method->setAccessible(true);
            $_method->invoke($this);
        }
        $this->getMapper()->setAttributes($this->getAttributes());
    }
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::postDispatch()
     */
    public function postDispatch()
    {
        $this->setAttributes($this->getMapper()->getAttributes());
        if($this->_controller->getResponse()->getHttpResponseCode() == 405){
            return;
        }
        $pd = array();
        $reflected = new ReflectionClass($this);
        foreach ($this->getOptions() as $key => $value) {
            $method = "_{$key}PostDispatch";
            if($reflected->hasMethod($method)){
                $pd[@$value['stackindex']['post'] ?: null] = $method;
            }
        }
        foreach ($pd as $method) {
            $_method = $reflected->getMethod($method);
            $_method->setAccessible(true);
            $_method->invoke($this);
        }
        $this->_controller->getResponse()
            ->setHeader('Content-Type','application/json');
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        if(!$this->_log){
            /* @var $bootstrap Zend_Zircote_Rest_Bootstrap_Bootstrap */
            $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            if (!$bootstrap->hasResource('Log')) {
                $writer = new Zend_Log_Writer_Null();
                $this->_log = new Zend_Log();
                $this->_log->addWriter($writer);
            } else {
                $this->_log = $bootstrap->getResource('Log')->getLog();
            }
        }
        return $this->_log;
    }
    /**
     *
     * @return string|boolean
     */
    public function methodRequest()
    {
        $options = $this->getOption('method');
        if($options['enabled']){
            if(($method = $this->_controller->getRequest()->getParam('_method', false))
            && $this->_controller->getRequest()->isPost()){
                return in_array(
                    strtoupper($method),
                    $this->_controller->_allow
                ) ? $method : false;
            }
        }
        return false;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _acceptPostDispatch()
    {
        $options = $this->getOption('accept');
        if($options['enabled'] && isset($options['defaults']['types'])){
            $this->_controller->getResponse()
            ->setHeader(
            'Accept',
            $this->_parseAcceptTypes($options['defaults']['types']
            )
            );
        }
        return $this;
    }
    /**
     *
     * @param array $types
     */
    protected function _parseAcceptTypes($types)
    {
        $result = array();
        foreach ($types as $type) {
            $result[] = $this->_parseAcceptType($type);
        }
        return implode(',', $result);
    }
    /**
     *
     * @param string $type
     */
    protected function _parseAcceptType($type)
    {
        $result = $type['type'];
        if(isset($type['level'])){
            $result .= ';level=' . $type['level'];
        }
        if(isset($type['q'])){
            $result .= ';q=' . $type['q'];
        }
        return $result;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _allowPostDispatch()
    {
        if(!$this->_controller->getResponse()->isException()){
            if(is_array($this->_controller->getAllow()) &&
                (bool) $this->_controller->getAllow()){
                $this->_controller->getResponse()
                    ->setHeader(
                        'Allow', implode(', ', $this->_controller->getAllow())
                    );
            }
        }
        return $this;
    }
    /**
     *
     * Here we will enforce the trailing / is not present in get requests in the
     * event it is we will forward to its operational counterpart with a 301
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _enforceTrailingPreDispatch()
    {
        $options = $this->getOption('enforceTrailing');
        if($options['enabled']){
            if($this->_controller->getRequest()->isGet()){
                if(preg_match('/.+\/$/', $this->_controller->getRequest()->getPathInfo())){
                    $filter = new Zend_Filter_PregReplace(
                    array('match' => '/\/$/','replace' => '')
                    );
                    $this->_redirect(
                        $filter->filter(
                            $this->_controller->getRequest()->getPathInfo()
                        ), 301
                    );
                }
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _fieldsPreDispatch()
    {
        $options = $this->getOption('fields');
        if($options['enabled']){
            if($result = $this->_controller->getRequest()->getParam('fields', null)){
                $this->_attributes['fields'] = explode(',',$result);
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _pagingPreDispatch()
    {
        $options = $this->getOption('paging');
        if($options['enabled']){
            $this->_attributes['paging'] = array(
            'offset' => $this->_controller->getRequest()
            ->getParam('offset',@$options['defaults']['offset'] ?: 1),
            'limit' => $this->_controller->getRequest()
            ->getParam('limit', @$options['defaults']['limit'] ?: 10)
            );
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _pagingPostDispatch()
    {
        $options = $this->getOption('paging');
        if($options['enabled']){
            if(isset($this->_attributes['paging']['count'])) {
                $count = $limit = $offset = 0;
                extract($this->_attributes['paging']);
                if(($offset+$limit)){
                    $start = (($limit * $offset) - $limit) + 1;
                    $end = ($limit * $offset);
                    $start = ($count > $start) ? $start : $count;
                    $end = ($count > $end) ? $end : $count;
                    if($end !== $count){
                        $this->_controller->getResponse()->setHeader(
                            'Range', sprintf('%s-%s/%s',$start,$end,$count)
                        );
                        $this->_controller->getResponse()->setHttpResponseCode(206);
                    }
                }
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _searchPreDispatch()
    {
        $options = $this->getOption('search');
        if($options['enabled']){
            if($q =  $this->_controller->getRequest()
            ->getParam(@$options['searchKey'] ? : 'q', null)){
                $this->_attributes['search']['query'] = $q;
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _sortPreDispatch()
    {
        $options = $this->getOption('sort');
        if($options['enabled']){
            if(null !== ($sort = $this->_controller->getRequest()->getParam('sort', null))){
                $this->_attributes['sort'] = $this->_getSort($sort);
            }
        }
        return $this;
    }
    /**
     *
     * @param array $data
     */
    protected function _getSort($data)
    {
        $result = array();
        foreach (explode(',',$data) as $value) {
            $result[] = str_ireplace(
            array('(asc)','(desc)'), array(' ASC',' DESC'), $value
            );
        }
        return $result;
    }
    /**
     * @todo should create a filter chain to ensure it is a valid javascript
     * function:
     *  - name begins with alpha
     *  - contains only /a-zA-Z0-9_/
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _jsonpPostDispatch()
    {
        $options = $this->getOption('jsonp');
        if($options['enabled']){
            if($callback = $this->_controller->getRequest()->getParam('callback', false)){
                $this->_controller->getResponse()->setHeader('Content-Type', 'application/json-p');
                $content = $this->_controller->getResponse()->getBody();
                $this->_controller->getResponse()->setBody(sprintf('%s(%s)',$callback,$content));
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _lastUpdatedPostDispatch()
    {
        $options = $this->getOption('lastUpdated');
        if($options['enabled'] && isset($this->_attributes['last_updated'])){
            if($lastUpdated = $this->_attributes['last_updated']){
                $this->_controller->getResponse()->setHeader('Last-Updated', $lastUpdated);
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Controller_RestControllerAbstract
     */
    protected function _loggingPreDispatch()
    {
        $options = $this->getOption('logging');
        if($options['enabled']){
            $filter = new Zend_Filter();
            $filter->addFilter(new Zend_Filter_StripNewlines())
            ->addFilter(
            new Zend_Filter_PregReplace(
            array('match' => '/\s\s+/', 'replace' => '')
            )
            );
            $message = str_replace(
            array('%%METHOD%%','%%PATHINFO%%','%%PARAMS%%'),
            array($this->_controller->getRequest()->getMethod(), $this->_controller->getRequest()->getPathInfo(),
            $filter->filter(print_r($this->_controller->getRequest()->getUserParams(), true))),
            $options['format']
            );
            $this->getLog()->info($message);
        }
        return $this;
    }
    protected function _redirect($url, $code = 301)
    {
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'redirector'
        )->setCode($code)->gotoUrl($url)->redirectAndExit();
    }
}