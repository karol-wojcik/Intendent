<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 15:16
 */

namespace AppBundle\Form\Type;


use AppBundle\Form\DataTransformer\IntToBooleanTransformer;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WarehouseType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new IntToBooleanTransformer();

		$builder
			->add('name', 'text')
			->add(
				$builder->create('isDefault', 'checkbox',
					array(
						'required' => false,
						'label' => 'Domyślny'
					)
				)->addModelTransformer($transformer)
			)
			->add('save', 'submit')
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Warehouse',
		));
	}
}