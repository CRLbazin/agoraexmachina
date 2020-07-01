<?php
namespace App\Form;

use App\Entity\Forum;
use App\Entity\Workshop;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ForumAnswerType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('name')				
				->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
				->add('parentForum', EntityType::class, [
					'class' => Forum::class,
					'choice_label' => 'name',
					'attr' => [
						'readonly' => 'readonly'
					]
				])
				->add('Submit', SubmitType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Forum::class,
		]);
	}

}