<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;

class UserQuestionnaireController extends Controller
{

    /**
     * redirige les utilisateurs sur le page index selon leur droits
     * @Route("/")
     */
    public function indexAction()
    {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->gestionQuetionnaireAction();
        } elseif (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->listeQuestionnaireAction();
        } else {
            return $this->redirect($this->generateUrl("fos_user_security_login"));
        }
    }

    /**
     * retourne la liste des questionnaire disponnible à un utilisateur
     * redirige les utilisateurs sur le page index selon leur droits
     */
    public function listeQuestionnaireAction()
    {
        $userId = $this->getUser()->getId();
        $questionnaires = $this->getQuestionnaireRepository()->questionnaireByUserWithoutReponse($userId);
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    /**
     * page de gestion pour les quesitonnaire
     */
    public function gestionQuetionnaireAction()
    {
        $questionnaires = $this->getQuestionnaireRepository()->findAll();
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexGestionQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    /**
     * page de gestion pour les quesitonnaire
     * @Route("/gestion/list/questionnaires/submit")
     */
    public function listQuetionnaireSubmitAction()
    {
        $questionnaires = $this->getQuestionnaireRepository()->listQuestionnairesSubmit();
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:listQuestionnaireSubmit.html.twig', array("questionnaires" => $questionnaires));
    }
    
    /**
     * page de gestion pour les quesitonnaire
     * @Route("/gestion/list/questionnaires/submit")
     */
    public function quetionnaireSubmitAction(Questionnaire $questionnaire)
    {
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:listQuestionnaireSubmit.html.twig', array("questionnaires" => $questionnaire));
    }

    /**
     * 
     * @return type
     */
    private function getQuestionnaireRepository()
    {
        return $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
    }

}
