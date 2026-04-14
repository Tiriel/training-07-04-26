<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Conference>
 */
class ConferenceRepository extends ServiceEntityRepository implements ConferenceRepositoryInterface
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

    /**
     * @return list<Conference>
     */
    public function listAll(): array
    {
        return $this->findAll();
    }

    /**
     * @return list<Conference>
     */
    public function searchByName(string $name): array
    {
        $qb = $this->createQueryBuilder('conference');

        $qb
            ->andWhere($qb->expr()->like('conference.name', ':name'))
            ->setParameter('name', "%{$name}%")
        ;

        return $qb->getQuery()->getResult();
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
}
