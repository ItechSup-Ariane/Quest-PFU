<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class QuestionnaireController extends Controller {

    public function indexQuestionnaireAction() {
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:indexQuestionnaire.html.twig');
    }

    public function listQuestionnaireAction() {
        $userId = $this->getUser()->getId();
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->questionnaireByUserWithoutReponse($userId);
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:listQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    public function displayQuestionnaireAction(Questionnaire $questionnaire, Request $request) {
        $user = $this->getUser();
        foreach ($questionnaire->getCategories() as $categorie) {
            foreach ($categorie->getQuestions() as $question) {
                if ($question->getReponses()->isEmpty()) {
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
            return $this->redirect($this->generateUrl("itech_sup_index"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:formQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
    }

    public function removeQuestionnaireAction(Questionnaire $questionnaire) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $em = $this->getDoctrine()->getManager();
        $em->remove($questionnaire);
        $em->flush();
    }

    public function succesQuestionnaireAction() {
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:succesForm.html.twig');
    }

}
