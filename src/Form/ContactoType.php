<?php

namespace App\Form;

use App\Entity\Contacto;
use App\Entity\Grupo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Translation\TranslatorInterface;


class ContactoType extends AbstractType
{
    public function __construct(TranslatorInterface $traductor)
    {
        $this->traductor = $traductor;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nombre',
                TextType::class, [
                    'label' => 'contacto.etiqueta_nombre',
                    'help' => 'contacto.ayuda_nombre',
                    'attr' => ['maxlength' => '50'],
                    'translation_domain' => 'contacto',
                ]
            )
            ->add(
                'direccion',
                TextareaType::class, [
                    'label' => 'contacto.etiqueta_direccion',
                    'help' => 'contacto.ayuda_direccion',
                    'required' => false,
                    'attr' => [ 'maxlength' => '255', ],
                    'translation_domain' => 'contacto',
                ]
            )
            ->add(
                'telefono',
                TextType::class, [
                    'label' => 'contacto.etiqueta_telefono',
                    'help' => 'contacto.ayuda_telefono',
                    'required' => false,
                    'attr' => ['maxlength' => '50', ],
                    'translation_domain' => 'contacto',
                ]
            )
            ->add(
                'email',
                EmailType::class, [
                    'label' => 'contacto.etiqueta_email',
                    'help' => 'contacto.ayuda_email',
                    'required' => false,
                    'attr' => ['maxlength' => '50', ],
                    'translation_domain' => 'contacto',
                ]
            )
            ->add(
                'grupo',
                EntityType::class, [
                    'class' => Grupo::class,
                    'label' => 'contacto.etiqueta_grupo',
                    'help' => 'contacto.ayuda_grupo',
                    'translation_domain' => 'contacto',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacto::class,
        ]);
    }
}
