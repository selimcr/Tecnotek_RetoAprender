<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFormType extends AbstractType
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
                ))->
            add('password', 'repeated', array (
            'type'            => 'password',
            'first_name'      => "pass",
            'second_name'     => "confirm",
            'invalid_message' => "Los passwords no coinciden!"
        ));
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_userformtype';
    }
}
