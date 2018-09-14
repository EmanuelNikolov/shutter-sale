<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterCamerasType extends AbstractType
{
    const SORT_BY = [
      'make',
      'model',
      'price',
    ];

    const ORDER_BY = [
      'ASC',
      'DESC',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('sortBy', ChoiceType::class, [
            'choices' => self::SORT_BY,
            'choice_label' => function ($choice, $key, $value) {
                return ucfirst($value);
            },
            'label_attr' => ['class' => 'sr-only'],
            'placeholder' => '- Sort By -',
          ])
          ->add('orderBy', ChoiceType::class, [
            'choices' => self::ORDER_BY,
            'choice_label' => function ($choice, $key, $value) {
                return ucfirst(strtolower($value . 'ending'));
            },
            'label_attr' => ['class' => 'sr-only'],
            'placeholder' => '- Order By -',
          ])
          ->add('stock', CheckboxType::class, [
            'label' => 'In Stock',
            'required' => false,
          ])
          ->add('submit', SubmitType::class, [
            'label' => 'Filter'
          ]);
    }
}
