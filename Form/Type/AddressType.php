<?php

namespace Maci\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Intl\Intl;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Maci\UserBundle\Entity\Address',
			'cascade_validation' => true
		));
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// ->add('prefix', 'hidden', array('required' => false))
			->add('name', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'name')))
			->add('surname', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'surname')))
			->add('company', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'company')))
			->add('address', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'address')))
			->add('floor', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'floor')))
			->add('cap', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'cap', 'maxlength' => 5)))
			->add('city', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'city')))
			->add('state', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'state_or_province')))
		;

		if (count($this->orders->getCountriesArray())) {
			foreach ($this->orders->getCountriesArray() as $key => $value) {
				$choices[Intl::getRegionBundle()->getCountryName($key)] = $key;
			}
			$builder->add('country', ChoiceType::class, array(
					'label_attr' => array('class'=> 'sr-only'), 
					'choices' => $choices,
					'attr' => array('placeholder' => 'country')
				));
		} else {
			$builder->add('country', ChoiceType::class, array(
					'label_attr' => array('class'=> 'sr-only'), 
					'choices' => Intl::getRegionBundle()->getCountryNames(),
					'attr' => array('placeholder' => 'country')
				));
		}

		$builder
			->add('telephon', TextType::class, array('label_attr' => array('class'=> 'sr-only'), 'attr' => array('placeholder' => 'telephon')))
			->add('info', TextareaType::class, array('label_attr' => array('class'=> 'sr-only'), 'required' => false, 'attr' => array('placeholder' => 'info')))
			->add('method', HiddenType::class, array('label_attr' => array('class'=> 'sr-only'), 'mapped' => false, 'required' => false))
			->add('cancel', ResetType::class)
			->add('save', SubmitType::class)
		;
	}

	public function getName()
	{
		return 'address';
	}
}
