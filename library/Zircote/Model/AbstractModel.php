<?php
/**
 *
 *
 * @author Robert Allen <rallen@ifbyphone.com>
 * @package Zircote
 * @subpackage Zircote_Model
 *
 *
 */
abstract class Zircote_Model_AbstractModel
{
    /**
     *
     * @var array
     */
    protected $_params = array();
    protected $_attributes = array(
        'fields' => null,
        'auth' => null
    );

    /**
     *
     * @param string $attr
     * @param mixed $value
     * @return Zircote_Model_AbstractModel
     */
    public function setAttribute($attr, $value)
    {
        $this->_attributes[$attr] = $value;
        return $this;
    }
    /**
     *
     * @param array $attr
     * @return Zircote_Model_AbstractModel
     */
    public function setAttributes(array $attr)
    {
        foreach ($attr as $key => $value) {
            if(key_exists($key, $this->_attributes)){
                $this->_attributes[$key] = $value;
            }
        }
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
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->fromArray($params);
    }
    /**
     * Returns all valid keys for the model in question.
     * @return array
     */
    public function getCols()
    {
        return array_keys($this->_params);
    }
    /**
     *
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_params[$name]);
    }
    /**
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->_params)){
            $this->_params[$name] = $value;
        }
    }
    /**
     *
     * @param string $name
     * @return multitype:NULL string |boolean
     */
    public function __get($name)
    {
        if(array_key_exists($name, $this->_params)){
            return $this->_params[$name];
        }
        return false;
    }
    /**
     *
     * @return array
     */
    public function toArray()
    {
        $result = array();
        if($this->_attributes['fields']){
            foreach ($this->_attributes['fields'] as $field) {
                $result[$field] = $this->_params[$field];
            }
            return $result;
        }
        return $this->_params;
    }
    /**
     *
     * @param array $data
     * @return void
     */
    public function fromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }
    /**
     * Converts the object into a string representation [JSON]
     *
     * @return string
     */
    public function toJson()
    {
        return Zend_Json::encode($this->toArray());
    }
    /**
     * Converts the object into a string representation [JSON] utilizing the
     * magic method said object may then be cast to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}