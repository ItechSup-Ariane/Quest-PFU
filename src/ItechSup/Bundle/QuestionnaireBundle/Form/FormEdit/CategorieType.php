<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit\QuestionType;

class CategorieType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array("label" => 'Titre'));
        $builder->add('questions', 'collection', array('type' => new QuestionType(),
            'prototype_name' => "__questions_prot__",
            'label' => '',
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'itechsup_bundle_questionnairebundle_categorie';
    }

}
