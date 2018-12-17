<?php

namespace Maci\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recaptcha', EWZRecaptchaType::class, array(
        	'label_attr'  => array('class'=> 'sr-only'),
	        'mapped'      => false,
			'constraints' => array(
			    new RecaptchaTrue()
			)
        ));
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
