<?php

namespace FinanceBundle\Form;

use FinanceBundle\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PaymentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', IntegerType::class)
            ->add('category')
            ->add('walletFrom')
            ->add('description')
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'date'
                )
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Payment::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'financebundle_payment';
    }
}
