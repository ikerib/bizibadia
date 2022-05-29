<?php

namespace App\Repository;

use App\Entity\Mailegua;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mailegua>
 *
 * @method Mailegua|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mailegua|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mailegua[]    findAll()
 * @method Mailegua[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaileguaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mailegua::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Mailegua $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Mailegua $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return Mailegua[] Returns an array of Mailegua objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Mailegua
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getLastTen()
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
        ;

        return $qb->getQuery()->setMaxResults(10)->getResult();
    }

    public function getByFinder(Mailegua $filter, $userNan)
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
        ;

        if ( $userNan) {
            $qb->innerJoin('m.erabiltzailea', 'e')
                ->andWhere('e.nan = :nan')->setParameter('nan', $userNan);
        }

        if ( $filter->getDateStart() ) {
            $qb->andWhere('m.dateStart >= :datestart')->setParameter('datestart', $filter->getDateStart());
        }

        if ( $filter->getBizikleta() ) {
            $qb->innerJoin('m.bizikleta','b')
                ->andWhere('b.id = :bizikletaId')->setParameter('bizikletaId', $filter->getBizikleta()->getId());
        }

        if ( $filter->getStartGunea() ) {
            $qb->innerJoin('m.startGunea', 's')
                ->andWhere('s.id = :startGuneaId')->setParameter('startGuneaId', $filter->getStartGunea()->getId());
        }

        return $qb->getQuery()->getResult();
    }
}
