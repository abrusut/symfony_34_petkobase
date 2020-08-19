<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('fechaNacimiento')
            ->add('domicilioCalle')
            ->add('domicilioNumero')
            ->add('numeroDocumento')
            ->add('sexo')
            ->add('telefono')
            ->add('email')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('fechaBaja')
            ->add('tipoDocumento', EntityType::class, array(
                'class' => 'AppBundle\Entity\TipoDocumento',
                'choice_label' => 'tipo',
                'placeholder' => 'Seleccione',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('localidad', EntityType::class, array(
                'class' => 'AppBundle\Entity\Localidad',
                'choice_label' => 'l_distrito',
                'placeholder' => 'Seleccione',
                'empty_data' => null,
                'required' => false
 
            )) 
            ->add('provincia', EntityType::class, array(
                'class' => 'AppBundle\Entity\Provincia',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione',
                'empty_data' => null,
                'required' => false
 
            )) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persona'
        ));
    }
}
