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
class V1_Service_Game_Game extends Zircote_Rest_AbstractService
{
    /**
     *
     * @var string
     */
    protected $_mapperClass = 'Pincrowd_Model_Mapper_Game_Game';
    /**
     * @see Zircote_Rest_AbstractService::getMapper()
     * @return Pincrowd_Model_Mapper_Game_Game
     */
    public function getMapper()
    {
        return parent::getMapper();
    }
    /**
     * @todo add Caching
     * @todo add authentication
     * @return Pincrowd_Model_Game_GameCollection
     */
    public function getCollection()
    {
    }
    /**
     *
     * @param string $id
     * @return Pincrowd_Model_Game_Game
     */
    public function getOne($id)
    {
    }
    /**
     * @return int
     */
    public function getCount()
    {
        $count = $this->getMapper()->getCount();
        return array('count' => $count);
    }
    /**
     * @param Pincrowd_Model_Game_Game $data
     */
    public function createOne($data)
    {
    }
    /**
     *
     * @param integer $id
     * @return Pincrowd_Model_Game_Game
     */
    public function updateOne($id)
    {
    }
    /**
     *
     * @param integer $id
     * @return void
     */
    public function deleteOne($id)
    {
    }
}