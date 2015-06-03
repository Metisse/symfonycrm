<?php

namespace Crm\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text')
            ->add('surname', 'text')
            ->add('company', 'entity', array(
                'class'     => 'CrmAppBundle:Company',
                'property'  => 'company.name'
            ) )
			->add('email', 'email')
			->add('phone', 'text')
			->add('save', 'submit', array('label' => 'Save Contact'));
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\ppBundle\Entity\Contact',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AppBundle\Entity\Contact',
        ));
    }

	public function getName()
	{
		return 'Contact';
	}
}