<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conference>
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    public function findBetweenDates(?\DateTimeImmutable $startAt = null, ?\DateTimeImmutable $endAt = null): array
    {
        if (null === $startAt && null === $endAt) {
            throw new \InvalidArgumentException('At least one of the dates must be provided.');
        }

        $qb = $this->createQueryBuilder('c');

        if ($startAt instanceof \DateTimeImmutable) {
            $qb->andWhere($qb->expr()->gte('c.startAt', ':startAt'))
               ->setParameter('startAt', $startAt);
        }

        if ($endAt instanceof \DateTimeImmutable) {
            $qb->andWhere($qb->expr()->lte('c.endAt', ':endAt'))
               ->setParameter('endAt', $endAt);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function save(Conference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conference $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Conference[] Returns an array of Conference objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conference
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
