<?php
/**
 *
 *
 *
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Controller
 */
/**
 * @ApiResource(
 *     basePath="http://api.pincrowd.com/v1",
 *     swaggerVersion="0.1a",
 *     apiVersion="1"
 * )
 * @Api (
 *     path="/matches",
 *     value="Gets collection of game matches",
 *     description=""
 *     )
 * @ApiProduces (
 *     'application/json',
 *     'application/json+hal',
 *     'application/json-p',
 *     'application/json-p+hal',
 *     'application/xml',
 *     'application/xml',
 *     'application/xml+hal'
 *     )
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Controller
 */
class V1_Match_MatchesMatchidController extends Pincrowd_Rest_AbstractController
{
    /**
     *
     * @var V1_Service_match_Routes
     */
    protected $_service;
    /**
     *
     * @var string
     */
    protected $_baseUri = '/v1';
    /**
     *
     * @var string
     */
    protected $_resource = 'match';
    /**
     * Default Allow
     * @var array
     */
    protected $_allow = array('GET','PUT','DELETE');
    /**
     * (non-PHPdoc)
     * @see Pincrowd_Rest_AbstractController::init()
     */
    public function init()
    {
        parent::init();
        $this->setService(new V1_Service_Match_Match($this->_options, $this));
    }
    /**
     * @GET
     * @ApiPatch /{match_id}
     * @ApiOperation(
     *     value="Fetches the match corresponding the the provided ID",
     *     responseClass="leadresonder_route",
     *     multiValueResponse=true,
     *     tags="MLR"
     * )
     * @ApiError(code=403,reason="User Not Authorized")
     * @see Pincrowd_Rest_AbstractController::getAction()
     */
    public function getAction()
    {
        switch ($this->_getParam('id')) {
            /* Generate and return the relevant count for the collection scope */
            case 'count':
                $response = $this->_service->getCount();
                $this->_lastResponse = new Pincrowd_Rest_CountResult(
                array('count' => $this->_service->getCount())
                );
                break;
                /* Standard Collection Resource Handler */
            default:
                $this->_lastResponse = $this->_service
                ->getRoute($this->_getParam('id'));
                break;
        }
        $this->getResponse()->appendBody($this->_getResultFormatted());
    }
    /**
     * @PUT
     * @ApiPath /{match_id}
     * @ApiOperation(
     *     value="Updates the existing match designated by the {match_id}",
     *     responseClass="match",
     *     multiValueResponse=false,
     *     tags="Match"
     * )
     * @ApiError(code=400,reason="Invalid ID Provided")
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Match Not Found")
     * @ApiParam(
     *     description="ID of the match being updated",
     *     required=true,
     *     allowMultiple=false,
     *     dataType="integer",
     *     name="match_id",
     *     paramType="path"
     * )
     * @ApiParam(
     *     description="match model being updated",
     *     required=true,
     *     allowMultiple=false,
     *     dataType="match",
     *     name="match",
     *     paramType="body"
     * )
     * @see Pincrowd_Rest_AbstractController::putAction()
     */
    public function putAction()
    {
        $this->_lastResponse = $this->_service->updateRoute($this->_getParam('id', null));
        $this->getResponse()->appendBody($this->_getResultFormatted());
    }
    /**
     * @DELETE
     * @ApiPath /{match_id}
     * @ApiOperation(
     *     value="Deletes the existing match designated by the {match_id}",
     *     responseClass="match",
     *     multiValueResponse=false,
     *     tags="Match"
     * )
     * @ApiError(code=400,reason="Invalid ID Provided")
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Match Not Found")
     * @ApiParam(
     *     description="ID of the match being updated",
     *     required=true,
     *     allowMultiple=false,
     *     dataType="integer",
     *     name="match_id",
     *     paramType="path"
     * )
     * @see Pincrowd_Rest_AbstractController::deleteAction()
     */
    public function deleteAction()
    {
        $this->_lastResponse = $this->_service->deleteRoute($this->_getParam('id'));
        $this->getResponse()->setHttpResponseCode(202);
        $this->getResponse()->appendBody(null);
    }
    /**
     *
     * @see Pincrowd_Rest_AbstractController::preDispatch()
     */
    public function preDispatch()
    {
        parent::preDispatch();
    }
}