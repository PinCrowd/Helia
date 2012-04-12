<?php
/**
 *
 *
 *
 * @category   Zircote
 * @package    Library
 * @subpackage Model
 */
/**
 *
 *
 *
 * @category   Zircote
 * @package    Library
 * @subpackage Model
 */
abstract class Zircote_Model_AbstractMapper
{

    /**
     *
     * @var Zend_Log
     */
    protected static $_log;
    /**
     *
     * @var string
     */
    protected $_lastUpdatedField;
    /**
     *
     * @param mixed $defaultDB
     */
    abstract public static function setDefaultDB($defaultDB);
    /**
     * @return mixed
     */
    abstract public static function getDefaultDB();
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
     * @return Zircote_Rest_AbstractMapper
     */
    abstract protected function _getSort();
    /**
     *
     * @return Zircote_Rest_AbstractMapper
     */
    abstract protected function _getFields();
    /**
     *
     * @return Zircote_Rest_AbstractMapper
     */
    abstract protected function _getPaging();
    /**
     *
     * @return Zircote_Rest_AbstractMapper
     */
    abstract protected function _getAuth();
    /**
     *
     * @return Zircote_Rest_AbstractMapper
     */
    abstract protected function _getSearch();
    /**
     *
     * @param string $attr
     * @param mixed $value
     * @return Zircote_Rest_AbstractMapper
     */
    public function setAttribute($attr, $value)
    {
        $this->_attributes[$attr] = $value;
        return $this;
    }
    /**
     *
     * @param array $attr
     * @return Zircote_Rest_AbstractMapper
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
}