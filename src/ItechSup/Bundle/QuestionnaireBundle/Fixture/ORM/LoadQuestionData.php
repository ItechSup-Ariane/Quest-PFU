<?php

namespace ItechSup\Bundle\QuestionBundle\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $question1 = new Question();
        $question1->setTitle("Question1");
        $question1->setCategorie($this->getReference('categorie1'));
        $manager->persist($question1);
        $manager->flush();

        $question2 = new Question();
        $question2->setTitle("Question2");
        $question2->setCategorie($this->getReference('categorie1'));
        $manager->persist($question2);
        $manager->flush();

        $question3 = new Question();
        $question3->setTitle("Question3");
        $question3->setCategorie($this->getReference('categorie2'));
        $manager->persist($question3);
        $manager->flush();

        $question4 = new Question();
        $question4->setTitle("Question4");
        $question4->setCategorie($this->getReference('categorie2'));
        $manager->persist($question4);
        $manager->flush();

        $question5 = new Question();
        $question5->setTitle("Question5");
        $manager->persist($question5);
        $manager->flush();

        $this->addReference('question1', $question1);
        $this->addReference('question2', $question2);
        $this->addReference('question3', $question3);
        $this->addReference('question4', $question4);
    }

    public function getOrder()
    {
        return 4;
    }

}
