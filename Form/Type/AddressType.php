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

use Maci\TranslatorBundle\Controller\TranslatorController;

/**
 * Address
 */
class AddressType extends AbstractType
{
	protected $orders;

	public function __construct($orders, TranslatorController $translator)
	{
		$this->translator = $translator;
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
			// ->add('prefix', 'hidden', ['required' => false])
			->add('name', TextType::class, [
				'label' => $this->translator->getLabel('name', 'Name'),
				'label_attr' => array('class'=> 'sr-only'),
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('name', 'Name')]
			])
			->add('surname', TextType::class, [
				'label' => $this->translator->getLabel('surname', 'Surname'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('surname', 'Surname')]
			])
			->add('company', TextType::class, [
				'label' => $this->translator->getLabel('company', 'Company'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => false,
				'attr' => ['placeholder' => $this->translator->getLabel('company', 'Company')]
			])
			->add('address', TextType::class, [
				'label' => $this->translator->getLabel('address', 'Address'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('address', 'Address')]
			])
			->add('floor', TextType::class, [
				'label' => $this->translator->getLabel('floor', 'Floor'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => false,
				'attr' => ['placeholder' => $this->translator->getLabel('floor', 'Floor')]
			])
			->add('cap', TextType::class, [
				'label' => $this->translator->getLabel('cap', 'Cap'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('cap', 'Cap'), 'maxlength' => 5]
			])
			->add('city', TextType::class, [
				'label' => $this->translator->getLabel('city', 'City'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('city', 'City')]
			])
			->add('state', TextType::class, [
				'label' => $this->translator->getLabel('state_or_province', 'State or Province'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => true,
				'attr' => ['placeholder' => $this->translator->getLabel('state_or_province', 'State or Province')]
			])
		;

		$countryChoices = $this->orders->getCountryChoices();

		if (count($countryChoices)) {

			$builder->add('country', ChoiceType::class, [
				'label' => $this->translator->getLabel('country', 'Country'),
				'label_attr' => ['class'=> 'sr-only'],
				'choices' => $countryChoices,
				'placeholder' => $this->translator->getLabel('select-country', 'Select Country')
			]);

		} else {

			$builder->add('country', CountryType::class, [
				'label' => $this->translator->getLabel('country', 'Country'),
				'label_attr' => ['class'=> 'sr-only'],
				'placeholder' => $this->translator->getLabel('select-country', 'Select Country')
			]);

		}

		$builder
			->add('telephon', TextType::class, [
				'label' => $this->translator->getLabel('telephon', 'Telephon'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => false,
				'attr' => ['placeholder' => $this->translator->getLabel('telephon', 'Telephon')]
			])
			->add('info', TextareaType::class, [
				'label' => $this->translator->getLabel('info', 'Info'),
				'label_attr' => ['class'=> 'sr-only'],
				'required' => false,
				'attr' => ['placeholder' => $this->translator->getLabel('info', 'Info')]
			])
			->add('method', HiddenType::class, [
				'label_attr' => ['class'=> 'sr-only'],
				'mapped' => false,
				'required' => false
			])
		;

		if (!$options['embedded']) {
			$builder
				->add('cancel', ResetType::class, [
					'label' => $this->translator->getLabel('cancel', 'Cancel'),
				])
				->add('save', SubmitType::class, [
					'label' => $this->translator->getLabel('save', 'Save'),
				])
			;
		}
	}

	public function getName()
	{
		return 'address';
	}
}
