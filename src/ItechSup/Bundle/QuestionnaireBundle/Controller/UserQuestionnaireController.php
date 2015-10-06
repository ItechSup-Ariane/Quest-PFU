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
        $render = $this->redirect($this->generateUrl("fos_user_security_login"));
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $questionnaires = $this->getQuestionnaireRepository()->findAll();
            $render = $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexGestionQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
        } elseif (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            $userId = $this->getUser()->getId();
            $questionnaires = $this->getQuestionnaireRepository()->questionnairesByUserWithoutReponse($userId);
            $render = $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
        }
        return $render;
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
     * @Route("/gestion/questionnaire/submit/{questionnaire}", requirements={"questionnaire": "\d+"})
     */
    public function quetionnaireSubmitAction(Questionnaire $questionnaire)
    {
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:questionnaireSubmit.html.twig', array("questionnaire" => $questionnaire));
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
