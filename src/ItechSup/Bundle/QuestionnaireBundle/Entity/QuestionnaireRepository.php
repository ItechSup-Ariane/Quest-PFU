<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionnaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionnaireRepository extends EntityRepository
{

    public function questionnaireByUserWithoutReponse($userId)
    {
        $query = $this->createQueryBuilder('q')
                ->join("q.categories", "c")
                ->join("c.questions", "cq")
                ->leftJoin("cq.reponses", "r")
                ->where("r.user != :userId")
                ->orWhere("r.user IS NULL")
                ->setParameter("userId", $userId)
                ->getQuery();
        return $query->getResult();
    }

    public function listQuestionnairesSubmit()
    {
        $query = $this->createQueryBuilder('q')
                ->join("q.categories", "c")
                ->join("c.questions", "cq")
                ->join("cq.reponses", "r")
                ->getQuery();
        return $query->getResult();
    }

}
