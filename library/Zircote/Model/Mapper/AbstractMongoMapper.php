<?php

abstract class Zircote_Model_Mapper_AbstractMongoMapper extends Zircote_Model_Mapper_AbstractDbMapper
{
    /**
     * (non-PHPdoc)
     * @see Zircote_Model_Mapper_AbstractDbMapper::setDb()
     * @param MongoDB $db
     * @return Zircote_Model_Mapper_AbstractMongoMapper
     */
    public function setDb(MongoDB $db){
        $this->_db = $db;
        return $this;
    }
    /**
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDb ()
    {
        if (! $this->_db instanceof MongoDB) {
            $this->_db = new MongoDB(new Mongo(), 'test');
        }
        return $this->_db;
    }
}