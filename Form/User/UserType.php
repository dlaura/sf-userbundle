<?php

namespace Onfan\UserBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('facebook_username')
            ->add('facebook_id')
            ->add('name')
            ->add('surname')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Onfan\UserBundle\Entity\User\User'
        ));
    }

    public function getName()
    {
        return 'onfan_userbundle_user_usertype';
    }
}
