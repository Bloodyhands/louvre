<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
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
				ChoiceType::class,
				$this->getConfiguration("Pays", "Sélectionnez votre pays")
				)
			->add('birthday_date',
				DateType::class,
				$this->getConfiguration("Date de naissance", "")
			)
			->add('type',
				CheckboxType::class,
				$this->getConfiguration("Tarifs réduits","")
			)
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ticket::class
		]);
	}
}
