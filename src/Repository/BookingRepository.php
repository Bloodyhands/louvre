<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

	/**
	 * Compteur de tickets
	 *
	 * @param \DateTime $reservationDate
	 * @return mixed
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
    public function countTicketsByDay(\DateTime $reservationDate)
	{
		return $this->createQueryBuilder('b')
			->select('COUNT(t.id)')
			->innerJoin('b.tickets', 't')
			->where('b.reservationDate LIKE :reservationDate')
			->setParameter('reservationDate', $reservationDate->format('Y-m-d').'%')
			->getQuery()
			->getSingleScalarResult();
	}

//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}