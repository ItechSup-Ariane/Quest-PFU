<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class UserQuestionnaireController extends Controller
{

    /**
     * redirige les utilisateurs sur le page index selon leur droits
     */
    public function indexAction()
    {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl("itech_sup_gestion"));
        } elseif (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl("itech_sup_list_questionnaire"));
        } else {
            return $this->redirect($this->generateUrl("fos_user_security_login"));
        }
    }

    /**
     * retourne la liste des questionnaire disponnible à un utilisateur
     */
    public function indexQuestionnaireAction()
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
    public function indexGestionAction()
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

    /**
     * Affiche le nouveau questionnaire et enregistre les données du formaulaire
     * @param Questionnaire $questionnaire
     * @param Request $request
     * @return type
     */
    public function displayQuestionnaireAction(Questionnaire $questionnaire, Request $request)
    {
        $user = $this->getUser();
        foreach ($questionnaire->getCategories() as $categorie) {
            foreach ($categorie->getQuestions() as $question) {
                if (!$question->hasReponseUser($user->getId())) {
                    $reponse = new Reponse();
                    $reponse->setUser($user);
                    $question->addReponse($reponse);
                } else {
                    return $this->redirect($this->generateUrl("itech_sup_index"));
                }
            }
        }
        $form = $this->createForm(new QuestionnaireType(), $questionnaire);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_questionnaire_succes_formulaire"));
        }
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:formQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
    }

    /**
     * page de confirmation du questionnaire
     * @return type
     */
    public function succesFormulaireAction()
    {
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:succesForm.html.twig');
    }

}
