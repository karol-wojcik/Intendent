<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 15:16
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationElementType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('product', 'entity', array(
				'class' => 'AppBundle:Product',
				'choice_label' => 'name'
			))
			->add('basePrice', 'money', array(
				'scale'  => 2,
				'currency' => 'PLN'
			))
			->add('quantity', 'number', array(
				'scale'  => 2
			))
			->add('value', 'money', array(
				'scale'  => 2,
				'currency' => 'PLN',
                'grouping' => true
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\OperationElement',
		));
	}
}