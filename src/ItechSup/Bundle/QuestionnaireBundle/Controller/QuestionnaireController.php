<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType as QuestionnaireTypeBase;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\QuestionnaireType as QuestionnaireTypeEdit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/edit/questionnaire/{idQuestionnaire}", requirements={"idQuestionnaire": "\d+"})
     * @param Questionnaire $questionnaire
     */
    public function editQuestionnaireAction($idQuestionnaire, Request $request)
    {
        $user = $this->getUser();
        $questionnaire = $this->getDoctrine()
                ->getManager()
                ->getRepository('ItechSupQuestionnaireBundle:Questionnaire')
                ->questionnaireByUserWithoutReponse($idQuestionnaire, $user->getId());
        $render = $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
        if (!empty($questionnaire)) {
            $questionnaire->createEmptyReponse($user);
            $form = $this->createForm(new QuestionnaireTypeBase(), $questionnaire);
            if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $render = $this->redirect($this->generateUrl("itechsup_questionnaire_userquestionnaire_index"));
            }
            $render = $this->render('ItechSupQuestionnaireBundle:Questionnaire:editQuestionnaire.html.twig', array("formQuestinnaire" => $form->createView()));
        }
        return $render;
    }

}
