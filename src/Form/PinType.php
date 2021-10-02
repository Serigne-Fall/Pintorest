<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Form\Type\TypeType;
use Vich\UploaderBundle\Form\Type\TextareaType;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' =>" Image (JPG, PGN or JPEG file)",
                'required' => true,
                'allow_delete' => true,
                'delete_label' => 'Delete',
                'imagine_pattern' => 'squared_thumbnail_small',
                'download_uri' => false,
            ])
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
