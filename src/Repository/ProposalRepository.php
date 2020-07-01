<?php
namespace App\Repository;

use App\Entity\Proposal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * @method Proposal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposal[]    findAll()
 * @method Proposal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposalRepository extends ServiceEntityRepository
{

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Proposal::class);
	}

	public function indexProposal($workshop, $user)
	{
		$entityManager = $this->getEntityManager();
		$query = $entityManager->createQueryBuilder();
		$query
				->select(
						'p', 
						'sum(v.votedFor)  as nbVotedFor', 
						'sum(v.votedAgainst)  as nbVotedAgainst', 
						'sum(v.votedBlank) as nbVotedBlank',
						'case when (sum(vu.votedFor) > 0) then \'votedFor\' else  '
						. 'case when (sum(vu.votedAgainst) > 0) then \'votedAgainst\' else '
						. 'case when (sum(vu.votedBlank) > 0) then \'votedBlank\' else \'\' end end end as userVote'
						)
				->from('App\Entity\Proposal', 'p')
				->leftJoin('p.votes', 'v')
				->leftJoin('p.votes', 'vu', 'WITH', 'vu.user = :user')
				->where('p.workshop = :workshop')
				->groupBy('p.id')
				->setParameter('workshop', $workshop)
				->setParameter('user', $user);
	
		return $query->getQuery()->getResult();
	}

}