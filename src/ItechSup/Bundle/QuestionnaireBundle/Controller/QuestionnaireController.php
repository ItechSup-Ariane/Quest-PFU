<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\QuestionnaireType;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;

class QuestionnaireController extends Controller {

    public function listQuestionnaireAction() {
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->findAll();
        return $this->render('ItechSupQuestionnaireBundle:Gestionnaire:listQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    public function addQuestionnaireAction(Request $request) {
        $form = $this->createForm(new QuestionnaireType());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Gestionnaire:formQuestionnaire.html.twig', array("addForm" => $form->createView()));
    }

    public function updateQuestionnaireAction(Questionnaire $questionnaire, Request $request) {
        $form = $this->createForm(new QuestionnaireType(), $questionnaire);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Gestionnaire:formQuestionnaire.html.twig', array("addForm" => $form->createView()));
    }

    public function removeQuestionnaireAction(Questionnaire $questionnaire) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($questionnaire);
        $em->flush();
        return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
    }

}
