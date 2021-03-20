<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    // méthode permettant de récupérer la donnée 'nom' de la table patient en bdd
    public function search(string $filter)
    {
        $builder = $this->createQueryBuilder('pat');

        $builder
            ->andWhere('pat.nom LIKE :nom')
            ->setParameter('nom', '%'. $filter . '%')
        ;

        $query = $builder->getQuery();

        return $query->getResult();

    }

    // méthode liée à l'autocomplétion de la barre de recherche

    public function autocomplete($term)
    {
        $qb = $this->createQueryBuilder('patient');

        $qb->select('patient.nom')
            ->where('patient.nom LIKE :term')
            ->setParameter('term', '%' . $term . '%');

        $arrayAss = $qb->getQuery()
            ->getResult();

        $array = array();

        // le résultat de la requête est bouclé afin d'effectuer la recherche sur chaque ligne de la table patient
        foreach ($arrayAss as $data) {

            $array[] = $data['nom'];
        }

        return $array;
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
