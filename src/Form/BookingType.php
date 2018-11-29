<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\TicketType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingType extends AbstractType
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
			->add('email',
				  TextType::class,
				  $this->getConfiguration("Email de réception des tickets", "Tapez email valide")
			)
			->add('reservation_date',
				  DateType::class,
				  $this->getConfiguration("date de réservation", ""),
				  [
				  'format' => 'dd-MM-yyyy'
				  ])
			->add('tickets', CollectionType::class, array(
					'entry_type' => TicketType::class,
					'allow_add' => true
		));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
								   'data_class' => Booking::class,
							   ]);
	}
}
