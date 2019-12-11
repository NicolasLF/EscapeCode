<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Student::class);
        $this->em = $em;
    }

    public function findSecret()
    {
        $sql = "SELECT student.city, MAX(student.birth_at), student.secret_id FROM student";

        /*------- Do not touch --------*/
        $statement = $this->em->getConnection()->prepare($sql);
        $statement->bindValue('city', 'La loupe');
        $statement->execute();
        $results = $statement->fetch();
        return $results;
        /*------- End Do not touch --------*/
    }
}
