<?php

namespace App\Repository;

use App\Entity\Passe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Passe>
 *
 * @method Passe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passe[]    findAll()
 * @method Passe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passe::class);
    }

    public function save(Passe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Passe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Passe[] Returns an array of Passe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findOneBySomeField($ID): ?Passe
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :ID')
            ->setParameter('ID', $ID)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
