<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType;

class QuestionnaireController extends Controller {

    public function listQuestionnaireAction() {
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->findAll();
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:listQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    public function displayQuestionnaireAction(Questionnaire $questionnaire, Request $request) {
        $form = $this->createForm(new QuestionnaireType(), $questionnaire);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:formQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
    }

    public function updateQuestionnaireAction() {
        die;
    }

    public function addQuestionnaireAction() {
        die;
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
