<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as LouvreAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
	const NORMAL = 16;
	const CHILDREN = 8;
	const SENIOR = 12;
	const REDUCE = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
	 *
	 * @Assert\Country
     */
    private $country;

    /**
     * @ORM\Column(type="datetime")
	 *
	 * @Assert\LessThanOrEqual("today")
	 *
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="integer", name="reducePrice")
     */
    private $reducePrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    public function getReducePrice(): ?int
    {
        return $this->reducePrice;
    }

    public function setReducePrice(int $reducePrice): self
    {
        $this->reducePrice = $reducePrice;

        return $this;
    }
}
