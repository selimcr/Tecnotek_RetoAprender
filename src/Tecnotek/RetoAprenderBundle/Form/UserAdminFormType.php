<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserAdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
            add('firstname', 'text', array('trim' => true))->
            add('lastname', 'text', array('trim' => true))->
            add('username', 'text', array('trim' => true))->
            add('email', 'email')->
            add('active', 'checkbox', array(
                'label'     => 'Active?',
                'required'  => false,
                ));
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_useradminformtype';
    }
}
