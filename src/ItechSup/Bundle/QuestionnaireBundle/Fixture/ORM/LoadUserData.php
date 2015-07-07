<?php

namespace ItechSup\Bundle\CategorieBundle\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ItechSup\Bundle\QuestionnaireBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('pfreneau');
        $user->setEmail('test@test.com');
        $user->setPlainPassword('pass');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));



        $user2 = $userManager->createUser();
        $user2->setUsername('pfreneau2');
        $user2->setEmail('test2@test.com');
        $user2->setPlainPassword('pass');
        $user2->setEnabled(true);
        $user2->setRoles(array('ROLE_ADMIN'));

        $userManager->updateUser($user);
        $userManager->updateUser($user2);
        
        $this->addReference('user', $user);
    }

    public function getOrder()
    {
        return 1;
    }

}
