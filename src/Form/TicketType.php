<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;

class TicketType extends AbstractType
{
	public function __construct(FrenchToDateTimeTransformer $transformer)
	{
		$this->transformer = $transformer;
	}

	/**
	 * Permet d'avoir la configuration de base d'un champ
	 *
	 * @param string $label
	 * @param string $placeholder
	 * @param array $options
	 * @return array
	 */
	private function getConfiguration($label, $placeholder, $options = []) {
		return array_merge([
							   'label' => $label,
							   'attr' => [
								   'placeholder' => $placeholder
							   ]
						   ], $options);
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name',
				  TextType::class,
				$this->getConfiguration("Nom", "Tapez votre nom")
				)
			->add('firstname',
				  TextType::class,
				$this->getConfiguration("Prénom", "Tapez votre prénom")
				)
			->add('country',
				CountryType::class,
				$this->getConfiguration("Pays", "Sélectionnez votre pays"),
				  array("preferred_choices" => array("France")
				  )
				)
			->add('birthdayDate',
				TextType::class,
				$this->getConfiguration("Date de naissance", ""),
				  [
					  'format' => 'dd-MM-yyyy'
				  ])
			->add('reducePrice',
				  CheckboxType::class,
				$this->getConfiguration("Tarifs réduits (étudiants, militaires, employé ministère de la culture)","", [
					"required"=>false
				])
			);

		$builder->get('birthdayDate')->addModelTransformer($this->transformer);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ticket::class
		]);
	}
}
