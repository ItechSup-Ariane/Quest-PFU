<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Form\FormEdit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'question'));
        $builder->add('categorie', 'entity', array('class' => 'ItechSup\Bundle\QuestionnaireBundle\Entity\Categorie',
            'property' => 'title'
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ItechSup\Bundle\QuestionnaireBundle\Entity\Question',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'itechsup_bundle_questionnairebundle_question';
    }

}
