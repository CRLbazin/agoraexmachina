<?php
namespace App\Form;

use App\Entity\Workshop;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WorkshopType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder
				->add('category', EntityType::class, [
					'class' => Category::class,
					'choice_label'	=> 'name'
				])
				->add('name')
				->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
				->add('imageFile', VichImageType::class, [
					'required'		 => false,
					'allow_delete'	 => true,
				])
				->add('dateBegin')
				->add('dateEnd')
				->add('rightsSeeWorkshop', ChoiceType::class, ['choices' => ['Everyone' => 'everyone']])
				->add('rightsVoteProposals', ChoiceType::class, ['choices' => ['Everyone' => 'everyone']])
				->add('rightsWriteProposals', ChoiceType::class, ['choices' => ['Everyone' => 'everyone']])
				->add('quorumRequired', PercentType::class)
				->add('rightsDelegation')
				->add('Submit', SubmitType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Workshop::class,
		]);
	}

}