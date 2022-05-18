<?php

namespace App\Repository;

use App\Entity\ErabiltzaileZigorra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ErabiltzaileZigorra>
 *
 * @method ErabiltzaileZigorra|null find($id, $lockMode = null, $lockVersion = null)
 * @method ErabiltzaileZigorra|null findOneBy(array $criteria, array $orderBy = null)
 * @method ErabiltzaileZigorra[]    findAll()
 * @method ErabiltzaileZigorra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErabiltzaileZigorraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ErabiltzaileZigorra::class);
    }

    public function add(ErabiltzaileZigorra $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ErabiltzaileZigorra $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllFromUser($userid)
    {
        $qb = $this->createQueryBuilder('ez')
            ->innerJoin('ez.erabiltzailea','u')
            ->andWhere('u.id = :userid')->setParameter('userid', $userid)
        ;

        return $qb->getQuery()->getResult();
    }
}
