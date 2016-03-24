<?php

namespace Base\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController as RestfulController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Hydrator;

abstract class AbstractRestfulController extends RestfulController 
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    protected $em;
    protected $nameEntity;
    protected $nameService;

	public function getList()
	{
        try {
            $data = $this->params()->fromQuery();

            if (count($data) > 0)
                $list = $this->getEm()->getRepository($this->getNameEntity())->findBy($data);
            else
                $list = $this->getEm()->getRepository($this->getNameEntity())->findAll();

            foreach ($list as $key => $entity) {
                $list[$key] = $entity->toArray();
            }

            return new JsonModel($list);
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
                'error' => $e->getMessage(),
            ));
        }
	}

	public function get($id)
	{
        try {
            $entity = $this->getEm()
                ->getRepository($this->getNameEntity())
                ->findOneById($id);

            return new JsonModel($entity->toArray());
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
                'error' => $e->getMessage(),
            ));
        }
	}

	public function create($data)
	{
		try {
            $service = $this->getServiceLocator()->get($this->getNameService());
            $entity = $service->persist($data);
            $this->response->setStatusCode(201);
            return new JsonModel($entity->toArray());
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
	}

	public function update($id, $data)
	{
		try {
            $service = $this->getServiceLocator()->get($this->getNameService());
            $entity = $service->persist($data, $id);
            return new JsonModel($entity->toArray());
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
	}

    public function patch($id, $data) {
        try {
            $service = $this->getServiceLocator()->get($this->getNameService());
            $entity = $service->persist($data, $id);
            return new JsonModel($entity->toArray());
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
                'error' => $e->getMessage(),
            ));
        }
    }

	public function delete($id)
	{
		try {
            $service = $this->getServiceLocator()->get($this->getNameService());
            $service->delete($id);
            $this->response->setStatusCode(204);
            return new JsonModel();
        } catch (\Exception $e) {
            $this->response->setStatusCode(405);
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
	}

    /**
     * Set serviceManager instance
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

	/**
	 *
	 * @return EntityManager
	 */
	public function getEm()
	{
		return $this->em;
	}

	/**
	 * @param mixed $em
	 */
	public function setEm($em)
	{
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public function getNameEntity()
	{
		return $this->nameEntity;
	}

	/**
	 * @param string $nameEntity
	 */
	public function setNameEntity(string $nameEntity)
	{
		$this->nameEntity = $nameEntity;
	}

	/**
	 * @return string
	 */
	public function getNameService()
	{
		return $this->nameService;
	}

	/**
	 * @param string $nameService
	 */
	public function setNameService(string $nameService)
	{
		$this->nameService = $nameService;
	}
}