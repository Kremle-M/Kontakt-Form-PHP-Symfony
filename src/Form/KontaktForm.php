<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class KontaktForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new Assert\Email(['message' => 'Zadejte platnou emailovou adresu.']),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Zpráva',
                'attr' => ['rows' => 10, 'cols' => 40],
                'constraints' => [
                    new Assert\Length([
                        'min' => 30,
                        'minMessage' => 'Zpráva musí mít alespoň {{ limit }} znaků.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Odeslat',
            ]);
    }
}