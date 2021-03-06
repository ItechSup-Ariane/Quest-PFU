<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ItechSup\Bundle\QuestionnaireBundle\Entity\CategorieRepository")

 */
class Categorie
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
     * @ORM\ManyToOne(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire", inversedBy="categories",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $questionnaire;

    /**
     * @ORM\OneToMany(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Question", mappedBy="categorie", cascade={"persist", "remove"})
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
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

    /**
     * Set title
     *
     * @param string $title
     * @return Categorie
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

    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public function addQuestion(Question $question)
    {
        $question->setCategorie($this);
        $this->questions[] = $question;
    }

    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function createEmptyReponse(User $user)
    {
        foreach ($this->questions as $question) {
            $question->createEmptyReponse($user);
        }
    }

}
