<?php

namespace User\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use User\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("jhon@developer.com.br")
            ->setUsername("developer")
            ->setPassword(123456)
            ->setPasswordClue('123456')
            ->setActive(true)
            ->setStatus(false);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("teste@teste.com.br")
            ->setUsername("testete")
            ->setPassword(123456)
            ->setPasswordClue('123456')
            ->setActive(true)
            ->setStatus(false);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("boot@teste.com.br")
            ->setUsername("testbo")
            ->setPassword(123456)
            ->setPasswordClue('123456')
            ->setActive(true)
            ->setStatus(false);
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }
}
