<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Commantaire;
use Container12uY4AE\getContainer_GetenvService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    
        public function findAll($filters=null)
        {
            
            $q = $this->createQueryBuilder('a');
                    if ($filters != null) {
                        $q->andWhere('a.auther IN (:authers)')
                            ->setParameter(':authers', array_values($filters));
                    }
                    $q->orderBy('a.created_at', 'ASC');
                    return $q->getQuery()->getResult();
        }
        function clean_input($input) {
            // Liste de mots vulgaires
            $vulgar_words = array("mot1", "mot2", "mot3");
            // Supprimer les espaces en début et fin de la chaîne
            $input = trim($input);
            // Supprimer les balises HTML et PHP
            $input = strip_tags($input);
            // Remplacer les mots vulgaires par des astérisques
            $input = str_ireplace($vulgar_words, "****", $input);
            return $input;
        }

        
        





//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}