<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use App\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;

class BookingType extends AbstractType
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
			->add('email',
				  EmailType::class,
				  $this->getConfiguration("Email de réception des billets", "Tapez email valide")
			)
			->add('reservation_date',
				  TextType::class,
				  $this->getConfiguration("Date de réservation", ""),
				  [
				  'format' => 'dd-MM-yyyy'
				  ])
			->add('tickets',
				  CollectionType::class, array(
					'entry_type' => TicketType::class,
					'allow_add' => true,
					'allow_delete' => true
		));

		$builder->get('reservation_date')->addModelTransformer($this->transformer);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
								   'data_class' => Booking::class,
							   ]);
	}
}
