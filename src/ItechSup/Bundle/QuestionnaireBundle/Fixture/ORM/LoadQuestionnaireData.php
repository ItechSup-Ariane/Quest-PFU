<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;

class LoadQuestionnaireData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $questionnaire1 = new Questionnaire();
        $questionnaire1->setTitle("Questionnaire1");
        $manager->persist($questionnaire1);
        $manager->flush();

        $questionnaire2 = new Questionnaire();
        $questionnaire2->setTitle("Questionnaire2");
        $manager->persist($questionnaire2);
        $manager->flush();

        $questionnaire3 = new Questionnaire();
        $questionnaire3->setTitle("Questionnaire3");
        $manager->persist($questionnaire3);
        $manager->flush();

        $questionnaire4 = new Questionnaire();
        $questionnaire4->setTitle("Questionnaire4");
        $manager->persist($questionnaire4);
        $manager->flush();

        $questionnaire5 = new Questionnaire();
        $questionnaire5->setTitle("Questionnaire5");
        $manager->persist($questionnaire5);
        $manager->flush();
        $this->addReference('questionnaire1', $questionnaire1);
        $this->addReference('questionnaire2', $questionnaire2);
    }

    public function getOrder()
    {
        return 2;
    }

}
