<?php

namespace Crm\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('vat', 'choice', array(
                'choices'   => array(0 => '0%', 21 => '21%'),
                'required'  => true
            ))
            ->add('tax', 'choice', array(
                'choices'   => array(0 => '0%', 9 => '9%', 15 => '15%', 21 => '21%'),
                'required'  => true
            ))
            ->add('company', 'entity', array(
                'class'     => 'CrmAppBundle:Company',
                'property'  => 'company.name'
            ) )
            ->add('invoiceDetails', 'collection', array(
                'type'          => new InvoiceDetailType(),
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ))
			->add('isPaid', 'checkbox', array(
                'label'     => 'Is invoice paid?',
                'required'  => false,
            ))
			->add('dueDate', 'date', array(
                'widget'    => 'single_text',
                'format'    => 'yyyy-MM-dd',
                'required'  => false
            ))
			->add('save', 'submit', array('label' => 'Save Invoice'));
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\ppBundle\Entity\Invoice',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AppBundle\Entity\Invoice',
        ));
    }

    public function getName()
	{
		return 'Invoice';
	}
}