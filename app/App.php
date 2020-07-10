<?php

namespace Shareexo;

use DI\ContainerBuilder;
use DI\Bridge\Slim\App as DIBridge;

class App extends DIBridge{

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'settings.displayErrorDetails' => true
        ]);

        $builder->addDefinitions(__DIR__ .DIRECTORY_SEPARATOR. 'container.php');
    }

}