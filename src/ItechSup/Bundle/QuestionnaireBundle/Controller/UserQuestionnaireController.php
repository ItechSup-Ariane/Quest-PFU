<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserQuestionnaireController extends Controller
{

    /**
     * redirige les utilisateurs sur le page index selon leur droits
     * @Route("/")
     */
    public function indexAction()
    {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->listeQuestionnaireAction();
        } elseif (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->gestionQuetionnaireAction();
        } else {
            return $this->redirect($this->generateUrl("fos_user_security_login"));
        }
    }

    /**
     * retourne la liste des questionnaire disponnible à un utilisateur
     */
    public function listeQuestionnaireAction()
    {
        $userId = $this->getUser()->getId();
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->questionnaireByUserWithoutReponse($userId);
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    /**
     * page de gestion pour les quesitonnaire
     */
    public function gestionQuetionnaireAction()
    {
        $em = $this->getDoctrine()->getManager();
        $questionnaireRepository = $em->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $categorieRepository = $em->getRepository('ItechSupQuestionnaireBundle:Categorie');
        $questionRepository = $em->getRepository('ItechSupQuestionnaireBundle:Question');
        $questionnaires = $questionnaireRepository->findAll();
        $categories = $categorieRepository->findAll();
        $questions = $questionRepository->findAll();
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexGestion.html.twig', array("questionnaires" => $questionnaires,
                    "categories" => $categories,
                    "questions" => $questions));
    }

}
