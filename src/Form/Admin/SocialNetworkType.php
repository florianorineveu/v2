<?php

namespace App\Form\Admin;

use App\Entity\SocialNetwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class SocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'     => 'Nom',
                'required'  => true,
            ])
            ->add('title', TextType::class, [
                'label'     => 'Titre',
                'required'  => false,
            ])
            ->add('classIcon', TextType::class, [
                'label'     => 'Classe CSS',
                'required'  => true,
            ])
            ->add('url', UrlType::class, [
                'label'         => 'URL',
                'required'      => true,
                'constraints'   => [
                    new Url(),
                    new NotBlank(),
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label'     => 'Activé',
                'required'  => false,
            ])
            ->add('position', IntegerType::class, [
                'label'     => 'Position',
                'required'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocialNetwork::class,
        ]);
    }
}
