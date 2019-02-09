<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{
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
	 * @Assert\Email(
	 *     message = "Cet email n'est pas valide",
	 *     checkMX = true
	 * )
     */
    private $email;

	/**
	 * @ORM\Column(type="datetime")
	 *
	 * @Assert\NotNull
	 * @Assert\GreaterThan("today", message="La date de réservation est antérieure à aujourd'hui")
	 *
	 */
	private $reservationDate;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking", orphanRemoval=true)
	 *
	 * @Assert\NotNull
     */
    private $tickets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dayType;

	/**
	 * Callback appelé à chaque fois qu'on crée une nouvelle réseravtion
	 *
	 * @ORM\PrePersist
	 *
	 * @return void
	 */
    public function prePersist()
	{
		if (empty($this->createdAt)) {
			$this->createdAt = new \DateTime();
		}
	}

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->created_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

	public function getReservationDate(): ?\DateTimeInterface
         	{
         		return $this->reservationDate;
         	}

	public function setReservationDate(\DateTimeInterface $reservationDate): self
         	{
         		$this->reservationDate = $reservationDate;
         
         		return $this;
         	}

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
	{
		if (!$this->tickets->contains($ticket)) {
			$this->tickets[] = $ticket;
			$ticket->setBooking($this);
		}

		return $this;
	}

    public function removeTicket(Ticket $ticket): self
	{
		if ($this->tickets->contains($ticket)) {
			$this->tickets->removeElement($ticket);
			// set the owning side to null (unless already changed)
			if ($ticket->getBooking() === $this) {
				$ticket->setBooking(null);
			}
		}

		return $this;
	}

    public function getDayType(): ?bool
    {
        return $this->dayType;
    }

    public function setDayType(bool $dayType): self
    {
        $this->dayType = $dayType;

        return $this;
    }
}
