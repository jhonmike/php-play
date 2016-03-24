<?php

namespace User\Controller;

use Base\Controller\AbstractRestfulController;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserController extends AbstractRestfulController
{
    /**
     * UserController constructor.
     * @param ServiceLocatorInterface $sl
     */
    public function __construct(ServiceLocatorInterface $sl)
    {
        $this->setServiceLocator($sl);
        $this->setEm($sl->get('Doctrine\ORM\EntityManager'));
        $this->setNameEntity("User\\Entity\\User");
        $this->setNameService("User\\Service\\UserService");
    }
}
