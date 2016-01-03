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

class OperationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('operationDate', 'date', array(
                'input'  => 'datetime',
                'widget' => 'choice',
                'format' => 'dd/MMMM/yyyy'
			))
			->add('externalId', 'text', array(
				'required' => false
			))
			->add('contractor', 'entity', array(
				'class' => 'AppBundle:Contractor',
				'choice_label' => 'name'
			))
            ->add('elements', 'collection', array(
				'entry_type' => new OperationElementType(),
				'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
			))
			->add('save', 'submit', array(
                'label' => 'Zapisz'
            ))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Operation',
		));
	}
}