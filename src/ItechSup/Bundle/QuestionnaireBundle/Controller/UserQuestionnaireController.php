<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class UserQuestionnaireController extends Controller {

    public function indexQuestionnaireAction() {
        $userId = $this->getUser()->getId();
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->questionnaireByUserWithoutReponse($userId);
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    public function indexGestionAction() {
        $em = $this->getDoctrine()->getManager();
        $questionnaireRepository = $em->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $categorieRepository = $em->getRepository('ItechSupQuestionnaireBundle:Categorie');
        $questionRepository = $em->getRepository('ItechSupQuestionnaireBundle:Question');
        $questionnaires = $questionnaireRepository->findAll();
        $categories = $categorieRepository->findAll();
        $questions = $questionRepository->findAll();
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:indexGestion.html.twig', array("questionnaire" => $questionnaires,
                    "categories" => $categories,
                    "question" => $questions));
    }

    public function displayQuestionnaireAction(Questionnaire $questionnaire, Request $request) {
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

    public function succesFormulaireAction() {
        return $this->render('ItechSupQuestionnaireBundle:UserQuestionnaire:succesForm.html.twig');
    }

}
