<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="ItechSup\Bundle\QuestionnaireBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse", mappedBy="user",cascade={"persist"})
     */
    private $reponses;

    public function __construct()
    {
        parent::__construct();
        $this->reponses = new ArrayCollection();
    }

    public function addReponse(Reponse $reponse)
    {
        $reponse->setUser($this);
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

}
