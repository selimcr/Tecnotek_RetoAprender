<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AnswerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('answerLabel', 'text', array('trim' => true))->
            add('type', 'choice', array(
            'choices'   => array('1' => 'Verdadera', '2' => 'Falsa'),
            'required'  => false,
        ))->
            add('question');
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_answerformtype';
    }
}
