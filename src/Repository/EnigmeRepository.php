<?php

namespace App\Repository;

use App\Entity\Enigme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enigme>
 *
 * @method Enigme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enigme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enigme[]    findAll()
 * @method Enigme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnigmeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enigme::class);
    }

    public function save(Enigme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Enigme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Enigme[] Returns an array of Enigme objects
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

//    public function findOneBySomeField($value): ?Enigme
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getEnigmeAleatoire($difficulte): ?array
{
    $ids = $this->createQueryBuilder('e')
        ->select('e.id')
        ->where('e.difficulte = :difficulte')
        ->setParameter('difficulte', $difficulte)
        ->getQuery()
        ->getResult();
        $randomId = $ids[array_rand($ids)];
    $enigme =  $this->createQueryBuilder('e')
        ->Where('e.id = :id')
        ->setMaxResults(1)
        ->setParameter('id', $randomId)
        ->getQuery()
        ->getResult();
 return $enigme;

}
}