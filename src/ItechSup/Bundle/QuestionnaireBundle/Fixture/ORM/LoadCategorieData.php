<?php

namespace ItechSup\Bundle\CategorieBundle\Fixture\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie;

class LoadCategorieData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $categorie1 = new Categorie();
        $categorie1->setTitle("Categorie1");
        $categorie1->setQuestionnaire($this->getReference('questionnaire1'));
        $manager->persist($categorie1);
        $manager->flush();

        $categorie2 = new Categorie();
        $categorie2->setTitle("Categorie2");
        $categorie2->setQuestionnaire($this->getReference('questionnaire1'));
        $manager->persist($categorie2);
        $manager->flush();

        $categorie3 = new Categorie();
        $categorie3->setTitle("Categorie3");
        $categorie3->setQuestionnaire($this->getReference('questionnaire2'));
        $manager->persist($categorie3);
        $manager->flush();

        $categorie4 = new Categorie();
        $categorie4->setTitle("Categorie4");
        $manager->persist($categorie4);
        $manager->flush();

        $categorie5 = new Categorie();
        $categorie5->setTitle("Categorie5");
        $manager->persist($categorie5);
        $manager->flush();

        $this->addReference('categorie1', $categorie1);
        $this->addReference('categorie2', $categorie2);
    }

    public function getOrder()
    {
        return 3;
    }

}
