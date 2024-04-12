<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 *
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

//    /**
//     * @return Image[] Returns an array of Image objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Image
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    // Dans App\Repository\ImageRepository.php

    public function findLast()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.id', 'DESC') // Assure-toi que 'id' est bien la clé primaire de ton entité Image
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findRandom()
    {
        $count = $this->createQueryBuilder('i')
            ->select("COUNT(i.id)")
            ->getQuery()
            ->getSingleScalarResult();

        $randomIndex = rand(0, $count -1);

        return $this->createQueryBuilder('i')
            ->setFirstResult($randomIndex)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

}
