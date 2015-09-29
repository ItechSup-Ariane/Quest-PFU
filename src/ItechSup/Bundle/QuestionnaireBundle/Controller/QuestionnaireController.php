<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormBase\QuestionnaireType;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Questionnaire;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class QuestionnaireController extends Controller
{

    /**
     * Ajoute un nouveau formulaire
     * @Route("/add/questionnaire")
     * @param Request $request
     * @return type
     */
    public function addQuestionnaireAction(Request $request)
    {
        $form = $this->createForm(new QuestionnaireType());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestionnaire_form2"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Questionnaire:formQuestionnaire2.html.twig', array("addForm" => $form->createView()));
    }

    /**
     * Affiche le nouveau questionnaire et enregistre les données du formaulaire
     * @Route("/edit/questionnaire/{questionnaire}", requirements={"questionnaire": "\d+"})
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

}
