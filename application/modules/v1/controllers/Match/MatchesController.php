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
class V1_Match_MatchesController extends Pincrowd_Rest_AbstractController
{

    /**
     *
     * @var string
     */
    protected $_baseUri = '/v1';
    /**
     *
     * @var string
     */
    protected $_resource = 'matches';
    /**
     *
     * @var V1_Service_match_Routes
     */
    protected $_service;
    /**
     * Default Allow
     * @var array
     */
    protected $_allow = array('GET','POST', 'OPTIONS', 'HEAD');
    /**
     *
     * @see Pincrowd_Rest_AbstractController::init()
     */
    public function init()
    {
        parent::init();
        $this->setService(new V1_Service_Match_Match($this->_options, $this));
        /* @var $bootstrap Pincrowd_Rest_Bootstrap_Bootstrap */
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        print_r($this->_service->getMapper()); exit;
        if($bootstrap->hasResource('db')){
            $this->_service->getMapper()->setDb($bootstrap->getResource('db'));
        }
        if($bootstrap->hasResource('log')){
            $log = $bootstrap->getResource('log');
        }
    }
    /**
     * @GET
     * @ApiOperation(
     *     value="Fetches a collection of matches",
     *     responseClass="match",
     *     multiValueResponse=true,
     *     tags="Match"
     * )
     * @ApiError(code=400,reason="Invalid ID Provided")
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Lead Responder Not Found")
     * @ApiParam(
     *     description="match being created",
     *     required=true,
     *     allowMultiple=false,
     *     dataType="match",
     *     name="match",
     *     paramType="body"
     * )
     *
     * @see Pincrowd_Rest_AbstractController::getAction()
     */
    public function getAction()
    {
        $this->_lastResponse = $this->_service->getCollection();
        $this->getResponse()->appendBody(
        $this->_getResultFormatted()
        );
    }
    /**
     *
     * @POST
     * @ApiOperation(
     *     value="Creates a new Match",
     *     responseClass="match",
     *     multiValueResponse=false,
     *     tags="Match"
     * )
     * @ApiError(code=400,reason="Invalid ID Provided")
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Lead Responder Not Found")
     * @ApiParam(
     *     description="match being created",
     *     required=true,
     *     allowMultiple=false,
     *     dataType="match",
     *     name="match",
     *     paramType="body"
     * )
     * @see Pincrowd_Rest_AbstractController::postAction()
     */
    public function postAction()
    {
        /* @todo must add validation */
        $data = $this->_service->createRoute();
        $this->getResponse()->appendBody($data);
    }
    /**
     *
     * @see Pincrowd_Rest_AbstractController::preDispatch()
     */
    public function preDispatch()
    {
        //         try {
        //             $this->_oauth->verifyAccessToken(
        //                 $this->_oauth->getBearerToken() /*, 'owner' */
        //             );
        //         } catch (OAuth2_AuthenticateException $authenticationException){
        //             $url = Zend_Uri_Http::fromString('http://org.local/v2/oauth/authorize');
        //             $url->setQuery(array(
        //                 'redirect_uri' => 'http://org.local/v1/match',
        //                 'client_id' => 'zircote',
        //                 'client_secret' => '54321',
        //                 'response_type' => 'token'
        //             ));;
        //             $this->_redirect((string) $url);
        // //             $authenticationException->sendHttpResponse();
        //         } catch (OAuth2_ServerException $serverException){
        //             $serverException->sendHttpResponse();
        //         }
        parent::preDispatch();
    }
    /**
     * (non-PHPdoc)
     * @see Pincrowd_Rest_AbstractController::postDispatch()
     */
    public function postDispatch()
    {
        parent::postDispatch();

    }
}