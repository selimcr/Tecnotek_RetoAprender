<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UnitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('name', 'text', array('trim' => true))->
            add('description', 'textarea', array('trim' => true, 'required' => false))->
            add('number')->
            add('level');
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_unitformtype';
    }
}
