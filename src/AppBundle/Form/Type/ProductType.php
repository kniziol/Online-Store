<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Type used to build form used to create / update product
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'app.label.product.name',
            ])
            ->add('description', null, [
                'label' => 'app.label.product.description',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'app.label.product.price',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'app.action.create',
                'attr'  => [
                    'class' => 'btn-primary',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Product::class,
            'translation_domain' => 'AppBundle',
        ]);
    }
}
