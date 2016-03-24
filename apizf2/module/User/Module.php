<?php

namespace User;

use User\Controller\UserController;
use User\Service\UserService;
use Zend\Http\Response;
use Zend\Mvc\Controller\ControllerManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => [
                'User\Controller\User' => function (ControllerManager $cm) {
                    return new UserController($cm->getServiceLocator());
                },
            ],
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'User\Service\UserService' => function($sm) {
                    return new UserService($sm->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }
}
