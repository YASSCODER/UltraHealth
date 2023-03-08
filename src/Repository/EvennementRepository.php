<?php

namespace App\Repository;

use App\Entity\Evennement;
use App\Entity\Passe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evennement>
 *
 * @method Evennement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evennement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evennement[]    findAll()
 * @method Evennement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvennementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evennement::class);
    }

    public function save(Evennement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveP(Passe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evennement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findEventsByEndDate($filters = null)
    {
        $qb = $this->createQueryBuilder('e');
        if ($filters != null) {
            $qb->andWhere('e.category IN (:cats)')
                ->setParameter(':cats', array_values($filters));
        }
        $qb->andWhere('e.dateFin >= :today')
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('e.dateFin', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function searchEvennements($searchTerm)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->where($qb->expr()->like('e.titre', ':searchTerm'))
            ->setParameter('searchTerm', '%' . $searchTerm . '%');

        return $qb->getQuery()->getResult();
    }

    public function findEntitiesByString($str)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App\Entity\Evennement e
                WHERE (e.titre LIKE :str) OR (e.zone LIKE :str)'
            )
            ->setParameter('str', '%' . $str . '%')
            ->getResult();
    }



    //    /**
    //     * @return Evennement[] Returns an array of Evennement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evennement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
