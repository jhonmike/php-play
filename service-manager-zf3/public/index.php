<?php

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Factory\InvokableFactory;
use Interop\Container\ContainerInterface;
use Play\Example;
use Play\Example2;


require_once __DIR__."/../vendor/autoload.php";

$serviceManager = new ServiceManager([
	'factories' => [
		Example::class => InvokableFactory::class,
		Example2::class => function(ContainerInterface $container, $requestName) {
			$example = $container->get(Example::class);
			return new Example2($example);
		}
	]
]);

$example2 = $serviceManager->get(Example2::class);

$example2->sayHello();