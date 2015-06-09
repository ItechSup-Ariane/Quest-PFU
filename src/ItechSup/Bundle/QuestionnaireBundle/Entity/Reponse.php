<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Response
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ItechSup\Bundle\QuestionnaireBundle\Entity\ResponseRepository")
 */
class Reponse {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="smallint")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Question", inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\User", inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Response
     */
    public function setScore($score) {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore() {
        return $this->score;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion(Question $question) {
        $this->question = $question;
    }

    public function getUser() {
        return $this->question;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

}
