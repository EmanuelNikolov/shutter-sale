<?php

namespace AppBundle\Form;

use AppBundle\Entity\Camera;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CameraType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('make', ChoiceType::class, [
          'choices' => Camera::getMakes(),
          'choice_label' => function ($choiceValue, $key, $value) {
              return $value;
          },
        ])
          ->add('model', TextType::class)
          ->add('price', NumberType::class, [
            'scale' => 2,
          ])
          ->add('quantity', IntegerType::class)
          ->add('minShutterSpeed', IntegerType::class)
          ->add('maxShutterSpeed', IntegerType::class)
          ->add('minIso', ChoiceType::class, [
            'choices' => Camera::getMinIsos(),
            'choice_label' => function ($choiceValue, $key, $value) {
                return $value;
            },
          ])
          ->add('maxIso', IntegerType::class)
          ->add('isFullFrame', CheckboxType::class, [
            'label' => "Is it Full Frame?",
            'required' => false,
          ])
          ->add('videoResolution', TextType::class)
          ->add('lightMetering', ChoiceType::class, [
            'choices' => Camera::getLightMeterings(),
            'multiple' => true,
            'expanded' => true,
            'choice_label' => function ($choiceValue, $key, $value) {
                return $value;
            },
            'label_attr' => [
              'class' => 'checkbox-inline',
            ],
          ])
          ->add('description', TextareaType::class)
          ->add('imageUrl', UrlType::class)
          ->add('submit', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => Camera::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_camera';
    }


}
