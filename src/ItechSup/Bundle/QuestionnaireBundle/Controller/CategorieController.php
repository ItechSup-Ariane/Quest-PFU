<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller {

    public function listCategorieAction() {
        $userId = $this->getUser()->getId();
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaires = $repositoryQuestionnaire->questionnaireByUserWithoutReponse($userId);
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:listQuestionnaire.html.twig', array("questionnaires" => $questionnaires));
    }

    public function addCategorieAction(Request $request) {
        $form = $this->createForm(new QuestionnaireType());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Gestionnaire:formQuestionnaire.html.twig', array("addForm" => $form->createView()));
    }

    public function updateCategorieAction(Questionnaire $questionnaire, Request $request) {
        $form = $this->createForm(new QuestionnaireType(), $questionnaire);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Gestionnaire:formQuestionnaire.html.twig', array("addForm" => $form->createView()));
    }

    public function removeCategorieAction(Questionnaire $questionnaire) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($questionnaire);
        $em->flush();
        return $this->redirect($this->generateUrl("itech_sup_gestionnaire_list_questionnaire"));
    }

}
