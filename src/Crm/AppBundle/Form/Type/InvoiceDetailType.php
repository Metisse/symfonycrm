<?php

namespace Crm\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text')
            ->add('type', 'choice', array(
                'choices'   => array(
                    'incoming'  => 'Incoming',
                    'expense'   => 'Expense',
                    'outlay'    => 'Outlay',
                ),
                'required'  => true
            ))
            ->add('amount', 'number');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\ppBundle\Entity\InvoiceDetail'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AppBundle\Entity\InvoiceDetail'
        ));
    }

    public function getName()
    {
        return 'InvoiceDetail';
    }
}