<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Form\QuestionnaireType;

class QuestionnaireController extends Controller {

    public function displayFormulaireAction(Request $request) {
        $repositoryQuestionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire');
        $questionnaire = $repositoryQuestionnaire->find(1);
        $form = $this->createForm(new QuestionnaireType(), $questionnaire);
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:index.html.twig', array("formQuestinnaire" => $form->createView()));
    }

    public function succesFormulaireAction() {
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:succesForm.html.twig');
    }

}
