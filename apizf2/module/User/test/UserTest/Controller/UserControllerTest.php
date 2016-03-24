<?php

namespace UserTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class UserControllerTest extends AbstractHttpControllerTestCase
{
    private $serviceManager;
    private $url;

    public function setUp()
    {
        parent::setUp();
        $this->setApplicationConfig(include __DIR__ . '/../../../../../config/application.config.php');
        $this->serviceManager = $this->getApplication()->getServiceManager();
        $this->url = '/user';
    }

    public function testGetList()
    {
        $this->dispatch($this->url);
        $this->assertResponseStatusCode(200);
    }

    public function testCreate()
    {
        $this->dispatch($this->url, 'POST', array(
            'id'     => '',
            'email'  => 'teste@jhonmike.com.br',
            'username' => 'teste',
            'password' => '123456',
            'password_clue' => '',
            'active' => false,
            'status' => false,
        ));
        $this->assertResponseStatusCode(201);

        $this->dispatch($this->url, 'POST', array(
            'id'     => '',
            'email'  => 'teste2@jhonmike.com.br',
            'username' => 'teste2',
            'password' => '123456',
            'password_clue' => '',
            'active' => false,
            'status' => false,
        ));
        $this->assertResponseStatusCode(201);
    }

    public function testGet()
    {
        $url = $this->url . "/1";
        $this->dispatch($url, 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testUpdate()
    {
        $url = $this->url . "/1";
        $this->dispatch($url, 'PUT', array(
            "id" => 1,
            "email" => "teste@jhonmike.com.br",
            "username" => "TesteUpdate",
            "password" => "123456",
            "password_clue" => "",
            "salt" => "lfeTBF3V1pw=",
            "active" => true,
            "activation_key" => "b47472b4cd8bd5c2ef6984492e9947af",
            "status" => false
        ));
        $this->assertResponseStatusCode(200);
    }

    public function testPatch()
    {
        $url = $this->url . "/1";
        $this->dispatch($url, 'PATCH', array(
            'status' => true
        ));
        $this->assertResponseStatusCode(200);
    }

//    public function testDelete()
//    {
//        $url = $this->url . "/1";
//        $this->dispatch($url, 'DELETE');
//        $this->assertResponseStatusCode(204);
//    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
