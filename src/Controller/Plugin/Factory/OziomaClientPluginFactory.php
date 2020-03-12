<?php
namespace Chibex\Ozioma\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Chibex\Ozioma\Controller\Plugin\OziomaClientPlugin;
use Chibex\Ozioma\Service\OziomaClientManager;

class OziomaClientPluginFactory
{
    public function __invoke(ContainerInterface $container)
    {        
        $oziomaClient = $container->get(OziomaClientManager::class);
        
        return new OziomaClientPlugin($oziomaClient);
    }
}
