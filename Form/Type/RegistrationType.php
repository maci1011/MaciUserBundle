<?php

namespace Maci\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class RegistrationType extends AbstractType
{
	protected $env;

	public function __construct($env)
	{
		$this->env = $env;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		if($this->env === "prod")
			$builder->add('recaptcha', EWZRecaptchaType::class, [
				'label_attr' => ['class'=> 'sr-only'],
				'mapped' => false,
				'constraints' => [new RecaptchaTrue()]
			]);
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';
	}

	public function getBlockPrefix()
	{
		return 'app_user_registration';
	}
}
