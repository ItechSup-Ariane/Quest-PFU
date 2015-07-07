<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\CategorieType;

class CategorieController extends Controller
{

    public function addCategorieAction(Request $request)
    {
        $form = $this->createForm(new CategorieType());
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestion"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Categorie:formCategorie.html.twig', array("addForm" => $form->createView()));
    }

    public function updateCategorieAction(Categorie $categorie, Request $request)
    {
        $form = $this->createForm(new CategorieType(), $categorie);
        if ($form->handleRequest($request)->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirect($this->generateUrl("itech_sup_gestion"));
        }
        return $this->render('ItechSupQuestionnaireBundle:Categorie:formCategorie.html.twig', array("addForm" => $form->createView()));
    }

    public function removeCategorieAction(Categorie $categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirect($this->generateUrl("itech_sup_gestion"));
    }

}
