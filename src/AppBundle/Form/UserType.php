<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('nombre')
            ->add('apellido')
            ->add('dni')
            ->add('plainPassword', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'options'           => array(
                    'translation_domain'    => 'FOSUserBundle',
                    'attr'                  => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options'     => array('label' => 'form.password'),
                'second_options'    => array('label' => 'form.password_confirmation'),
                'invalid_message'   => 'fos_user.password.mismatch',
                'required'          => false,
            ))
            ->add('enabled', CheckboxType::class, array(
                'label'     => 'Activo',
                'required'  => false
            ))
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('createdBy')
//            ->add('updatedBy')
            ->add('roles', ChoiceType::class, array(
                'choices'  => [
                    'Administrador' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
