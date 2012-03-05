<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package Zircote
 * @subpackage Model
 *
 *
 */
abstract class Zircote_Model_AbstractModelCollection extends ArrayObject
{
    protected $_itemKey = 'item';
    protected $_attributes = array(
        'fields' => null,
        'paging' => null,
        'search' => null,
        'sort' => null,
        'auth' => null
    );
    protected $_service;
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
     * Allows customication of the itemKey at runtime.
     * @param string $itemKey
     * @throws Zend_Validate_Exception
     * @return AbstractModelCollection
     */
    public function setItemKey($itemKey)
    {
        $validation = new Zend_Validate_Alpha();
        if(!$validation->isValid($itemKey)){
            throw new Zend_Validate_Exception(
                sprintf('string [%s] must be alpha [a-zA-Z]', $itemKey)
            );
        }
        $this->_itemKey = $itemKey;
        return $this;
    }
    /**
     * Provides a mechanism to discover the current value of the itemKey
     * @return string
     */
    public function getItemKey()
    {
        return $this->_itemKey;
    }
    /**
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        $xml = new SimpleXMLElement("<{$this->_itemKey}s/>");
        /* @var $item Zircote_Model_AbstractModel */
        foreach ($this->getIterator() as $k => $item){
            $xml->addChild($this->_itemKey);
            foreach ($item->toArray() as $key => $value) {
                $xml->{$this->_itemKey}[$k]->addChild($key,$value);
            }
        }
        return $xml;
    }
    /**
     * This will provide assurances that the appended item is of the corrrect
     * model type.
     * <code>
     * public function append(Zircote_Model_SomeModel $model)
     * {
     *     parent::append($model);
     * }
     * </code>
     * @param Zircote_Model_AbstractModel $item
     */
    public function append(Zircote_Model_AbstractModel $item){
        parent::append($item);
    }
    /**
     * @throws RuntimeException
     * @return array
     */
    public function toArray()
    {
        $result = array();
        foreach ($this->getArrayCopy() as $child) {
            if($child instanceof Zircote_Model_AbstractModel){
                $result[] = $child->toArray();
            } else {
                throw new RuntimeException(
                    'child item is not of type [Zircote_Model_AbstractModel]'
                );
            }
        }
        return $result;
    }
    /**
     *
     * @return string
     */
    public function __toJson()
    {
        return Zend_Json::encode($this->toArray());
    }
    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->__toJson();
    }
}