<?php

namespace App\Repository;

use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Workshops|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workshops|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workshops[]    findAll()
 * @method Workshops[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workshop::class);
    }
	
	public function searchBy(array $filters)
	{
		$entityManager = $this->getEntityManager();
		$query = $entityManager->createQueryBuilder();
		$query
				->select('w')
				->from('App\Entity\Workshop', 'w');
		
		
		foreach($filters as $key => $value)
		{
			if (gettype($value) == "object")
			{
				$query->andWhere('w.'.$key .' = :' . $key);
				$query->setParameter($key, $value);
			}
			else
			{
				$query->andWhere('w.'.$key .' LIKE :' . $key);
				$query->setParameter($key, '%'.$value.'%');
			}
		}
		
		dump($query);
	
		return $query->getQuery()->getResult();
	}
}
