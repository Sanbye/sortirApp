<?php

namespace App\Repository;

use App\Entity\Etat;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\True_;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function save(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return sortie[] Returns an array of sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function findAllWithQueries($filtres,$participant) {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->innerJoin('s.etat', 'e');


        if($filtres->getCampus()!=null) {
            $queryBuilder->andWhere('s.Campus = :campusSelected')
                ->setParameter('campusSelected', $filtres->getCampus());
        }
        if($filtres->getSearch()!=null) {
            $queryBuilder->andWhere('s.nom LIKE :searchSelected')
                ->setParameter('searchSelected', '%'.$filtres->getSearch().'%');
        }
        $queryBuilder->andWhere('s.dateHeureDebut  >= :dateStartSelected')
            ->setParameter('dateStartSelected', $filtres->getDateStart());
        $queryBuilder->andWhere('s.dateHeureDebut <= :dateEndSelected')
            ->setParameter('dateEndSelected', $filtres->getDateEnd());


            // CHOICE ORGANISATEUR
        if($filtres->getChoiceOrganisateur()) {
            $queryBuilder->andWhere('s.organisateur = :participant')
                ->setParameter('participant', $participant);
        }

            // CHOICE INSCRIT
        if($filtres->getChoiceInscrit()==true) {
            $queryBuilder->andWhere(':participant MEMBER OF s.participants')
                ->setParameter('participant', $participant);
        }

            // CHOICE NO INSCRIT
        if($filtres->getChoiceNoInscrit()==true) {
            $queryBuilder->andWhere(':participant NOT MEMBER OF s.participants')
                ->setParameter('participant', $participant);
        }

        // CHOICE SORTIES END
        if($filtres->getChoiceEnd()==true) {
            $queryBuilder->andWhere('e.libelle = :etat')
                ->setParameter('etat', 'cloturée');
        }

        //$queryBuilder->andWhere('s.vote > 7');
        //$queryBuilder->addOrderBy('s.popularity', 'DESC');
        dump($query = $queryBuilder->getQuery());

        //$query->setMaxResults(50);
        //$paginator = new Paginator($query);
        $results = $query->getResult();

        // return $paginator;
        return $results;
    }
//    public function findOneBySomeField($value): ?sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
