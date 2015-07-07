<?php

namespace ItechSup\Bundle\CategorieBundle\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class LoadReponseData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $reponse1 = new Reponse();
        $reponse1->setScore(1);
        $reponse1->setQuestion($this->getReference('question1'));
        $reponse1->setUser($this->getReference('user'));
        $manager->persist($reponse1);
        $manager->flush();

        $reponse2 = new Reponse();
        $reponse2->setScore(2);
        $reponse2->setQuestion($this->getReference('question2'));
        $reponse2->setUser($this->getReference('user'));
        $manager->persist($reponse2);
        $manager->flush();

        $reponse3 = new Reponse();
        $reponse3->setScore(3);
        $reponse3->setQuestion($this->getReference('question3'));
        $reponse3->setUser($this->getReference('user'));
        $manager->persist($reponse3);
        $manager->flush();

        $reponse4 = new Reponse();
        $reponse4->setScore(4);
        $reponse4->setQuestion($this->getReference('question4'));
        $reponse4->setUser($this->getReference('user'));
        $manager->persist($reponse4);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }

}
