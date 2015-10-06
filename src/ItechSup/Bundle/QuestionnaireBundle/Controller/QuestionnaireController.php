<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\QuestionnaireType as QuestionnaireTypeEdit;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType as QuestionnaireTypeBase;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class QuestionnaireController extends Controller
{

    /**
     * Ajoute un nouveau formulaire
     * @Route("/add/questionnaire")
     * @param Request $request
     * @return mixed
     */
    public function addQuestionnaireAction(Request $request)
    {
        $form = $this->createForm(new QuestionnaireTypeEdit());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:addQuestionnaire.html.twig', array("addForm" => $form->createView()));
    }

    /**
     * mise à jour d'un formulaire
     * @Route("/update/questionnaire/{questionnaire}", requirements={"questionnaire": "\d+"})
     * @param Questionnaire $questionnaires
     * @return mixed
     */
    public function updateQuestionnaireAction(Request $request, Questionnaire $questionnaire)
    {
        $form = $this->createForm(new QuestionnaireTypeEdit(), $questionnaire);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:updateQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
    }

    /**
     * Supprimer un formulaire
     * @Route("/delete/questionnaire/{questionnaire}", requirements={"questionnaire": "\d+"})
     * @param Questionnaire $questionnaire
     * @return mixed
     */
    public function deleteQuestionnaireAction(Questionnaire $questionnaire)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($questionnaire);
        $em->flush();
        return $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
    }

    /**
     * Affiche le formulaire à remplir à l'utilisateur
     * @Route("/edit/questionnaire/{questionnaire}", requirements={"questionnaire": "\d+"})
     * @param Questionnaire $questionnaire
     */
    public function editQuestionnaireAction(Questionnaire $questionnaire, Request $request)
    {
        $user = $this->getUser();
        foreach ($questionnaire->getCategories() as $categorie) {
            foreach ($categorie->getQuestions() as $question) {
                if (!$question->hasReponseUser($user->getId())) {
                    $reponse = new Reponse();
                    $reponse->setUser($user);
                    $question->addReponse($reponse);
                } else {
                    return $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
                }
            }
        }
        $form = $this->createForm(new QuestionnaireTypeBase(), $questionnaire);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:editQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
    }

}
