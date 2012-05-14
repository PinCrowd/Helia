<?php
/**
 *
 *
 *
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Service
 */
/**
 *
 *
 *
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Service
 */
class V1_Service_Match_Match extends Pincrowd_Rest_AbstractService
{
    protected $_mapperClass = 'Pincrowd_Model_Mapper_Match_Matches';
    /**
     *
     * @var string
     */
    protected $_lastUpdatedField;
    /**
     *
     * @param Zend_Db_Adapter_Abstract $db
     */
    public function __construct ($db = null)
    {
//         if ($db instanceof Zend_Db_Adapter_Abstract) {
//             $this->setDb($db);
//         }
    }
    /**
     *
     * @param Pincrowd_Model_Match $match
     * @return Pincrowd_Model_Match
     */
    public function saveById (Pincrowd_Model_Match $match)
    {
    }
    /**
     *
     * @param Pincrowd_Model_Match $match
     */
    public function update (Pincrowd_Model_Match $match)
    {
    }
    /**
     *
     * @param Pincrowd_Model_Match $match
     * @return Pincrowd_Model_Match
     */
    public function create(Pincrowd_Model_Match $match)
    {
    }
    /**
     * Return all routes for an account
     * @param Pincrowd_Model_Match mailRoute
     * @return Pincrowd_Model_MatchCollection
     */
    public function getList(Pincrowd_Model_MatchCollection $matches)
    {
    }
    /**
     * Return all routes for an account
     * @param Pincrowd_Model_Match mailRoute
     * @return Pincrowd_Model_MatchCollection
     */
    public function getById(Pincrowd_Model_MatchCollection $matches)
    {
    }
    /**
     *
     * @return Zend_Db_Select
     */
    protected function _prepareSql()
    {
    }
    /**
     * Return a count of all routes for an account
     * @return int
     */
    public function getCount()
    {
    }
    /**
     * Delete a route
     * @param Pincrowd_Model_Match $mail_route
     * @return boolean
     */
    public function deleteRoute(Pincrowd_Model_Match $match)
    {
    }
    /**
     *
     * @param string $id
     * @return Pincrowd_Model_AbstractModel
     */
    public function getOne($id)
    {

    }
    /**
     * @param Pincrowd_Model_AbstractModel $data
     */
    public function insert($data)
    {

    }
    /**
     *
     * @param integer $id
     * @return Pincrowd_Model_AbstractModel
     */
    public function update($id)
    {

    }
    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete($id)
    {

    }
}