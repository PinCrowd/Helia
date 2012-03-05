<?php
abstract class Zircote_Model_Mapper_AbstractDbMapper
{
    /**
     *
     * @var Zend_Log
     */
    protected static $_log;
    /**
     *
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    /**
     *
     * @var Zend_Db_Select
     */
    protected $_select;
    /**
     *
     * @var string
     */
    protected $_searchField;
    /**
     *
     * @param string $attr
     * @param mixed $value
     * @return Zircote_Model_AbstractModelCollection
     */
    public function setAttribute($attr, $value)
    {
        $this->_attributes[$attr] = $value;
        return $this;
    }
    /**
     *
     * @param array $attr
     * @return Zircote_Model_AbstractModelCollection
     */
    public function setAttributes(array $attr)
    {
        $this->_attributes = $attr;
        return $this;
    }
    /**
     *
     * @param string $attr
     * @return mixed
     */
    public function getAttribute($attr)
    {
        return @$this->_attributes[$attr] ?: null;
    }
    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
    /**
     *
     * @param Zend_Db_Adapter_Abstract $db
     * @return Zircote_Model_Mapper_AbstractDbMapper
     */
    public function setDb (Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
        return $this;
    }
    /**
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDb ()
    {
        if (! $this->_db instanceof Zend_Db_Adapter_Abstract &&
         Zend_Db_Table::getDefaultAdapter() instanceof Zend_Db_Adapter_Abstract) {
            $this->_db = Zend_Db_Table::getDefaultAdapter();
        }
        return $this->_db;
    }
    /**
     *
     * @param Zend_Log $log
     */
    public static function setLog(Zend_Log $log)
    {
        self::$_log = $log;
    }
    /**
     *
     * @return Zend_Log
     */
    public static function getLog()
    {
        if(!self::$_log instanceof Zend_Log){
            $log = new Zend_Log();
            $log->addWriter(new Zend_Log_Writer_Null);
            self::setLog($log);
        }
        return self::$_log;
    }
    /**
     *
     * @return Zircote_Model_Mapper_LeadResponder_MailRoute
     */
    protected function _getSort()
    {
        $sort = $this->getAttribute('sort');
        if($this->_select instanceof Zend_Db_Select && (bool) $sort){
            foreach ($sort as $field){
                $this->_select->order($field);
            }
        }
        return $this;
    }
    /**
     * @todo must validate somewhere that these are valid fields before
     *       constructing the query
     *
     * @return Zircote_Model_Mapper_LeadResponder_MailRoute
     */
    protected function _getFields()
    {
        $fields = $this->getAttribute('fields');
        if($this->_select instanceof Zend_Db_Select && (bool) $fields ){
            $this->_select->from(self::DB_TABLE, $fields);
        } else {
            $this->_select->from(self::DB_TABLE);
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Model_Mapper_LeadResponder_MailRoute
     */
    protected function _getPaging()
    {
        $paging = $this->getAttribute('paging');
        if($this->_select instanceof Zend_Db_Select && (bool) $paging){
            $this->_select->limitPage($paging['offset'], $paging['limit']);
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Model_Mapper_LeadResponder_MailRoute
     */
    protected function _getAuth()
    {
        $auth = $this->getAttribute('auth');
        if($this->_select instanceof Zend_Db_Select && (bool) $auth){
            foreach ($auth as $key => $value) {
                $this->_select
                    ->where(
                        sprintf('`%s` = :%s', $key,$key),
                        array($key => $value)
                    );
            }
        }
        return $this;
    }
    /**
     *
     * @return Zircote_Model_Mapper_LeadResponder_MailRoute
     */
    protected function _getSearch()
    {
        $search = $this->getAttribute('search');
        if($this->_select instanceof Zend_Db_Select
            && (bool) $search && $this->_searchField){
            $this->_select
                ->where(sprintf( '%s LIKE ?', $this->_searchField), '%'.$search['query'].'%');
        }
        return $this;
    }
}