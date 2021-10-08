<?php

namespace Maci\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\Countries;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Address
 */
class AddressType extends AbstractType
{
	protected $orders;

	public function __construct($orders)
	{
		$this->orders = $orders;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Maci\UserBundle\Entity\Address',
			'embedded' => false,
			// 'cascade_validation' => true
		));
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// ->add('prefix', 'hidden', array('required' => false))
			->add('name', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'name')))
			->add('surname', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'surname')))
			->add('company', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'company')))
			->add('address', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'address')))
			->add('floor', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'floor')))
			->add('cap', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'cap', 'maxlength' => 5)))
			->add('city', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'city')))
			->add('state', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => true, 'attr' => array('placeholder' => 'state_or_province')))
		;

		$countryChoices = $this->orders->getCountryChoices();

		if (count($countryChoices)) {

			$builder->add('country', ChoiceType::class, array(
				'label_attr' => array('class'=> 'sr-only'), 
				'choices' => $countryChoices,
				'placeholder' => 'Country'
			));

		} else {

			$builder->add('country', CountryType::class, array(
				'label_attr' => array('class'=> 'sr-only'),
				'placeholder' => 'Country'
			));

		}

		$builder
			->add('telephon', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'telephon')))
			->add('info', TextareaType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'info')))
			->add('method', HiddenType::class, array('label_attr' => array('class'=> 'sr-only'), 'mapped' => false, 'required' => false))
		;

		if (!$options['embedded']) {
			$builder
				->add('cancel', ResetType::class)
				->add('save', SubmitType::class)
			;
		}
	}

	public function getName()
	{
		return 'address';
	}
}
