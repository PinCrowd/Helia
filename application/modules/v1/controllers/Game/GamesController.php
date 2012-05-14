<?php
/**
 *
 *
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Controller
 */
/**
 * @apiresource(
 *     basePath="http://api.pincrowd.com/v1",
 *     swaggerVersion="0.1a",
 *     apiVersion="1"
 * )
 * @Api (
 *     path="/games",
 *     value="Gets collection of Game objects.",
 *     description=""
 *     )
 * @ApiProduces (
 *     'application/json',
 *     'application/json+hal',
 *     'application/json-p',
 *     'application/json-p+hal',
 *     )
 *
 *
 * @category   Pincrowd
 * @package    Helia
 * @subpackage Controller
 */
class V1_Game_GamesController extends Pincrowd_Rest_AbstractController
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
    protected $_resource = 'games';
    /**
     *
     * @var V1_Service_Game_Games
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
        $this->setService(new V1_Service_Game_Game($this->_options, $this));
        /* @var $bootstrap Pincrowd_Rest_Bootstrap_Bootstrap */
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        if($bootstrap->hasResource('db')){
            $this->_service->getMapper()->setDb($bootstrap->getResource('db'));
        }
        if($bootstrap->hasResource('log')){
            $log = $bootstrap->getResource('log');
        }
    }
    /**
     *
     * @GET
     * @ApiPath
     * @ApiOperation(
     *     value="Gets a collection of all Games.",
     *     responseClass=games,
     *     multiValueResponse=true,
     *     tags="games"
     * )
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Games Not Found")
     */
    public function getAction()
    {
        $this->_lastResponse = $this->_service->getList();
        $this->getResponse()->appendBody(
            $this->_getResultFormatted()
        );
    }
    /**
     *
     * @POST
     * @ApiPath
     * @ApiOperation(
     *     value="Creates an new Game as defined by the post parameters",
     *     responseClass=games,
     *     multiValueResponse=false,
     *     tags="games"
     * )
     * @ApiError(code=400,reason="Invalid Data Provided")
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Game Not Found")
     * @ApiParam(
     *     description="Game being created",
     *     required=true,
     *     dataType=games,
     *     paramType=body
     * )
     */
    public function postAction()
    {
        /**
         * @todo must add validation
         */
        $data = json_decode($this->getRequest()->getRawBody(), true);
        $data = new Pincrowd_Model_Game_Game($data);
        $this->_lastResponse = $this->_service->insert($data);
        $this->_lastResponse->player = $this->_lastResponse->player;
        $this->getResponse()->appendBody(
            $this->_getResultFormatted()
        );

    }
    /**
     *
     * @HEAD
     * @ApiPath
     * @ApiOperation(
     *     value="Returns the headers, and no body, for a GET on the Game collection.",
     *     multiValueResponse=false,
     *     tags="games"
     * )
     * @ApiError(code=403,reason="User Not Authorized")
     * @ApiError(code=404,reason="Games Not Found")
     */
    public function preDispatch()
    {
//         try {
//             $this->_oauth->verifyAccessToken(
//                 $this->_oauth->getBearerToken() /*, 'owner' */
//             );
//         } catch (OAuth2_AuthenticateException $authenticationException){
//             $url = Zend_Uri_Http::fromString('http://helia.local/v2/oauth/authorize');
//             $url->setQuery(array(
//                 'redirect_uri' => 'http://helia.local/v1/games',
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