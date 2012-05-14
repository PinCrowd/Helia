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
class V1_Service_Game_Game extends Pincrowd_Rest_AbstractService
{
    /**
     *
     * @var string
     */
    protected $_mapperClass = 'Pincrowd_Model_Mapper_Game_Games';
    /**
     * @see Pincrowd_Rest_AbstractService::getMapper()
     * @return Pincrowd_Model_Mapper_Game_Games
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
    public function getList()
    {
        $collection = new Pincrowd_Model_Game_GameCollection();
        foreach ($this->getMapper()->find() as $game) {
            $collection->append(new Pincrowd_Model_Game_Game($game));
        }
        return $collection;
    }
    /**
     *
     * @param string $id
     * @return Pincrowd_Model_Game_Game
     */
    public function getOne($id)
    {
        $data = $this->getMapper()->findById($id);
        return new Pincrowd_Model_Game_Game($data);
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
    public function insert($data)
    {
        $data = $data->toArray(true);
        $data = $this->getMapper()->insert($data);
        return new Pincrowd_Model_Game_Game($data);

    }
    /**
     *
     * @param integer $id
     * @return Pincrowd_Model_Game_Game
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