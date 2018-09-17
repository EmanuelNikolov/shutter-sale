<?php

namespace AppBundle\Form;

use AppBundle\Form\Model\FilterCameras;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterCamerasType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('sortBy', ChoiceType::class, [
            'choices' => FilterCameras::VALID_SORT_BY,
            'choice_label' => function ($choice, $key, $value) {
                return ucfirst($value);
            },
            'label_attr' => ['class' => 'sr-only'],
            'placeholder' => '- Sort By -',
          ])
          ->add('orderBy', ChoiceType::class, [
            'choices' => FilterCameras::VALID_ORDER_BY,
            'choice_label' => function ($choice, $key, $value) {
                return ucfirst(strtolower($value) . 'ending');
            },
            'label_attr' => ['class' => 'sr-only'],
            'placeholder' => '- Order By -',
          ])
          ->add('stock', CheckboxType::class, [
            'label' => 'In Stock',
            'required' => false,
          ])
          ->add('submit', SubmitType::class, [
            'label' => 'Filter',
          ])
          ->setMethod("GET");
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => FilterCameras::class,
          'csrf_protection' => false
        ]);
    }
}
