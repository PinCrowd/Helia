<?php
/**
 *
 *
 * @author Robert Allen <zircote@zircote.com>
 * @package ZfApiVersion
 * @subpackage Application
 *
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
public function _initRestHandler ()
    {
        Zend_Controller_Front::getInstance()
            ->setDefaultControllerName('not-found')
            ->registerPlugin(new Zend_Controller_Plugin_PutHandler())
            ->getRouter()
            ->removeDefaultRoutes();
    }
    protected function _initConfigMerge()
    {
        $path = realpath(APPLICATION_PATH . '/configs/routes');
        $directory = new DirectoryIterator($path);
        /* @var $item DirectoryIterator */
        foreach ($directory as $item) {
            if(!$item->isDot() && $item->isFile() && strstr($item->getFilename(), '.ini')){
                $parsed = new Zend_Config_Ini($path . '/' .$item->getFilename(), APPLICATION_ENV);
                $merged = $this->mergeOptions($this->getOptions(), $parsed->toArray());
                $this->setOptions($merged);
            }
        }
    }
//     protected function _initAutoLoader()
//     {
//         $loader = new Zircote_Loader_AutoLoader_Resource();
//         $autoloader = Zend_Loader_Autoloader::getInstance()
//             ->pushAutoloader($loader, 'OAuth2');
//     }
}

