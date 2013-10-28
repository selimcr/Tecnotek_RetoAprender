<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('leftSide', 'textarea', array('trim' => true, 'required' => false))->
            add('centerSide', 'textarea', array('trim' => true, 'required' => false))->
            add('rightSide', 'textarea', array('trim' => true, 'required' => false));
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_infoformtype';
    }
}
