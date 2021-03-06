<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ItechSup\Bundle\QuestionnaireBundle\Entity\QuestionnaireRepository")
 */
class Questionnaire
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function addCategory(Categorie $categorie)
    {
        $categorie->setQuestionnaire($this);
        $this->categories[] = $categorie;
        return $this;
    }

    public function removeCategory(Categorie $categorie)
    {
        $this->applications->removeElement($categorie);
    }

    public function getCategories()
    {
        return $this->categories->toArray();
    }

    public function createEmptyReponse(User $user)
    {
        foreach ($this->categories as $categorie) {
            $categorie->createEmptyReponse($user);
        }
    }

}
