<?php

namespace App\Repository;

use App\Entity\Brewerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brewerie>
 *
 * @method Brewerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewerie[]    findAll()
 * @method Brewerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brewerie::class);
    }

    public function add(Brewerie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Brewerie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find all ordered by title ASC using DQL
     */
    public function findAllOrderedByStateAscDql()
    {
        // Need to use EntityManager to create a request with Doctrine  
        $entityManager = $this->getEntityManager();

        // Request creation 
        $query = $entityManager->createQuery(
            // SELECT all object $brewerie FROM Brewerie
            // ordered by state name 
            'SELECT b
            FROM App\Entity\Brewerie AS b
            ORDER BY b.state, b.name  ASC')
        ;//->setParameter('brewerie', $brewerie)

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * Find by id 
     * 
     */

     public function findById(int $id)
     {
        return $this->find($id); 

     }


    // public function findByState(string $state): ?Brewerie
    // {
    //     return $this->createQueryBuilder('b')
    //     ->andWhere('b.state = :state')
    //     ->setParameter('state', $state)
    //         ->orderBy('b.name', 'ASC')
    //         // ->setMaxResults(1)
    //         ->getQuery()
            
    //         ->getResult();
                
    // }

//    /**
//     * @return Brewerie[] Returns an array of Brewerie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Brewerie
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
