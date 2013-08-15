<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('testDescription', 'textarea', array('trim' => true))->
            add('urlImage', 'text', array('trim' => true, 'required' => false))->
            add('type', 'choice', array(
            'choices'   => array('1' => 'Simple', '2' => 'Otro'),
            'required'  => false,
        ))->
            add('unit');
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_testformtype';
    }
}
