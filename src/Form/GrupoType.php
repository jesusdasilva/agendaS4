<?php

namespace App\Form;

use App\Entity\Grupo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class GrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nombre'//,
                //TextType::class,
                //['label'=>'Grupo','help'=> 'Nombre del grupo','attr'=>['maxlength'=>50,],]
            )
            ->add(
                'descripcion',TextareaType::class
                //['label'=>'Descripción','help'=>'Breve descripción','required'=>false,'attr'=>['maxlength'=>255,],]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grupo::class,
        ]);
    }
}
