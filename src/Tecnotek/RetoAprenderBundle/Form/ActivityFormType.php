<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('name', 'text', array('trim' => true))->
            add('description', 'textarea', array('trim' => true, 'required' => false))->
            add('includeText', 'textarea', array('trim' => true, 'required' => false))->
            add('type', 'choice', array(
            'choices'   => array('1' => 'Flash', '2' => 'JavaScript Presentation', '3' => 'Test'),
            'required'  => false,
            ))->
            add('unit');
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_activityformtype';
    }
}
