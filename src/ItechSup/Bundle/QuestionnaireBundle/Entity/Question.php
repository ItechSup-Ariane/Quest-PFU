<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ItechSup\Bundle\QuestionnaireBundle\Entity\QuestionRepository")
 */
class Question
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
     * @ORM\ManyToOne(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie", inversedBy="questions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse", mappedBy="question",cascade={"persist"})
     */
    private $reponses;

    /**
     * Get id
     *
     * @return integer 
     */
    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function addReponse(Reponse $reponse)
    {
        $reponse->setQuestion($this);
        $this->reponses[] = $reponse;
        return $this;
    }

    public function removeReponse(Reponse $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    public function getReponses()
    {
        return $this->reponses;
    }

    public function getReponse()
    {
        return $this->reponses->first();
    }

    public function hasReponseUser($userId)
    {
        return $this->reponses->exists(function ($key, $value) use ($userId) {
                    return $value->getUser()->getId() == $userId;
                });
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
    }

}
