<?php

namespace Tecnotek\RetoAprenderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('email', 'email');
        $builder->add('phone', 'number');
        $builder->add('subject', 'text');
        $builder->add('message', 'textarea');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => new MinLength(5),
            'email' => new Email(array('message' => 'Invalid email address')),
            'phone' => new MinLength(5),
            'subject' => new MinLength(5),
            'message' => new MinLength(5),
        ));

        $resolver->setDefaults(array(
            'validation_constraint' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'reto_aprender_contact';
    }
}

