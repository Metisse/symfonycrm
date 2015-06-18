<?php

namespace Crm\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text')
			->add('taxCode', 'text')
			->add('address', 'text')
			->add('city', 'text')
			->add('zipCode', 'text')
			->add('province', 'entity', array(
				'class'     => 'CrmAppBundle:Province',
				'property'  => 'province.name',
			) )
            ->add('country', 'entity', array(
                'class'     => 'CrmAppBundle:Country',
                'property'  => 'country.name'
            ) )
			->add('email', 'email')
			->add('phone', 'text')
			->add('fax', 'text', array('required' => false))
			->add('website', 'url', array('required' => false))
			->add('save', 'submit', array('label' => 'Save Company'));
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\ppBundle\Entity\Company',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AppBundle\Entity\Company',
        ));
    }

	public function getName()
	{
		return 'company';
	}
}