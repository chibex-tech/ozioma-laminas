<?php
namespace Chibex\Ozioma;

return [
    // We register module-provided controller plugins under this key.
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\OziomaClientPlugin::class => Controller\Plugin\Factory\OziomaClientPluginFactory::class,
        ],
        'aliases' => [
            'oziomaClient' => Controller\Plugin\OziomaClientPlugin::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\OziomaClientManager::class => Service\Factory\OziomaClientManagerFactory::class,
        ],
    ],
];
