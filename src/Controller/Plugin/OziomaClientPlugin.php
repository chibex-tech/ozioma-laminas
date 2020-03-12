<?php
namespace Chibex\Ozioma\Controller\Plugin;

// This block of code makes it possible for this Ozioma module to work with Zend Framework 3 and Laminas.
// If your project is in ZF3 you can use this module, if it's in Laminas you can as well use it.
$dymamicParent = '\Laminas\Mvc\Controller\Plugin\AbstractPlugin';
if (class_exists('\Zend\Mvc\Controller\Plugin\AbstractPlugin')) 
    $dymamicParent = '\Zend\Mvc\Controller\Plugin\AbstractPlugin';

eval("class DynamicAbstractPlugin extends $dymamicParent {}");

/**
 * This controller plugin is designed to let you send sms using Ozioma API
 * inside your controller.
 */
class OziomaClientPlugin extends \DynamicAbstractPlugin
{
    /**
     * Ozioma service manager.
     * @var Ozioma\Service\OziomaClientManager
     */
    private $oziomaClient = null;
    
    /**
     * Constructor. 
     */
    public function __construct($oziomaClient) 
    {
        $this->oziomaClient = $oziomaClient;
    }

    /**
     * This method is called when you invoke this plugin in your controller: $oziomaClient = $this->oziomaClient();
     * @return OziomaClientManager
     */
    public function __invoke()
    {    
        return $this->oziomaClient;
    }
}
