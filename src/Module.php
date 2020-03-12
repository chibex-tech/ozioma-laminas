<?php
/**
 * @link      https://chibex.net/ozioma
 * @copyright Copyright (c) 2018 Chibex Technologies. (https://chibex.net)
 */

namespace Chibex\Ozioma;

class Module
{
    const VERSION = '1.0.0';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
