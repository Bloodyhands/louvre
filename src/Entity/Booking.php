<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
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
     */
    private $email;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $reservation_date;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created_at;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $total_price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking", orphanRemoval=true)
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function setTotalPrice($total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

	public function getReservationDate(): ?\DateTimeInterface
	{
		return $this->reservation_date;
	}

	public function setReservationDate(\DateTimeInterface $reservation_date): self
	{
		$this->reservation_date = $reservation_date;

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
}
