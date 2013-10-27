<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('left', 'textarea', array('trim' => true, 'required' => false))->
            add('center', 'textarea', array('trim' => true, 'required' => false))->
            add('right', 'textarea', array('trim' => true, 'required' => false));
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_infoformtype';
    }
}
