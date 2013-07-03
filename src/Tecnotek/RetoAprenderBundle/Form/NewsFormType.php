<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('title', 'text', array('trim' => true))->
            add('content', 'textarea', array('trim' => true, 'required' => false))->
            add('enabled');
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_newsformtype';
    }
}
