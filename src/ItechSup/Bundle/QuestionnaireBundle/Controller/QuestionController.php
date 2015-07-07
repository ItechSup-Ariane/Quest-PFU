<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Question;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\QuestionType;

class QuestionController extends Controller
{

    public function addQuestionAction(Request $request)
    {
        $form = $this->createForm(new QuestionType());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestion"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Question:formQuestion.html.twig', array("addForm" => $form->createView()));
    }

    public function updateQuestionAction(Question $question, Request $request)
    {
        $form = $this->createForm(new QuestionType(), $question);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestion"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Question:formQuestion.html.twig', array("addForm" => $form->createView()));
    }

    public function removeQuestionAction(Question $question)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirect($this->generateUrl("itech_sup_gestion"));
    }

}
