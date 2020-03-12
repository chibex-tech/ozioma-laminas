<?php
namespace Chibex\Ozioma\Service\Factory;

use Interop\Container\ContainerInterface;
use Chibex\Ozioma\Service\OziomaClientManager;

/**
 * This is the factory class for OziomaClientManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class OziomaClientManagerFactory
{
    /**
     * This method creates the OziomaClientManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $config = $container->get('config');
        if(!isset($config['ozioma']['third-party']['access-key']))
        {
        	throw new \Exception("Please provide your Ozioma API Access Key in ozioma.global.php. Guide here https://github.com/chibex-tech/ozioma-laminas");
        }
        
        return new OziomaClientManager(new \Chibex\Ozioma ($config['ozioma']['third-party']['access-key']));
    }
}
