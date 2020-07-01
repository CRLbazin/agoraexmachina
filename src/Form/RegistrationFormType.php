<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('username', null, [
					'label'	 => false,
					'attr'	 => [
						'placeholder' => 'Username'
						],
					'constraints'	 => [
						new NotBlank([
							'message' => 'Please enter an username',
								]),
						new Length([
							'max'		 => 40,
							'maxMessage' => 'length.max.40',
							// max length allowed by Symfony for security reasons
							'max'		 => 40,
								]),
					],
				])
				->add('email', EmailType::class, [
					'label'	 => false,
					'attr'	 => [
						'placeholder' => 'Email'
					]
				])
				->add('plainPassword', PasswordType::class, [
					'mapped'		 => false,
					'constraints'	 => [
						new NotBlank([
							'message' => 'Please enter a password',
								]),
						new Length([
							'min'		 => 6,
							'minMessage' => 'length.min.6',
							// max length allowed by Symfony for security reasons
							'max'		 => 4096,
								]),
					],
					'label'			 => false,
					'attr'			 => [
						'placeholder' => 'Password'
					]
				])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}

}