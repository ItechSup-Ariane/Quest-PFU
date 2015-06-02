<?php

namespace ItechSup\Bundle\QuestionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use ItechSup\Bundle\QuestionnaireBundle\Entity\Reponse;

class QuestionType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('reponses', 'collection', array('label' => 'question',
            'type' => new ReponseType(),
            'allow_add' => false,
            'allow_delete' => false
        ));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $question = $event->getData();
            if ($question->getReponses()->isEmpty()) {
                $question->addReponse(new Reponse());
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ItechSup\Bundle\QuestionnaireBundle\Entity\Question',
            'empty_data' => function (FormInterface $form) {
                
            }
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'itechsup_bundle_questionnairebundle_question';
    }

}
