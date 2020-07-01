<?php
namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Proposal;
use App\Entity\User;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{

	/**
	 * @Route("/{slug}/workshop/proposal/{proposal}/vote/{userVote}/user/{user}", name="vote_add", methods={"GET", "POST"})
	 */
	public function add(Request $request, string $slug, Proposal $proposal, string $userVote, User $user): Response
	{
		$entityManager = $this->getDoctrine()->getManager();

		$vote = $entityManager->getRepository(Vote::class)->findOneBy([
			'user'		 => $user,
			'proposal'	 => $proposal
				]
		);

		//case insert
		if( ! $vote)
			$vote = new Vote();

		$vote->setUser($this->getUser());
		$vote->setProposal($proposal);
		$vote->setVotedFor(($userVote == "votedFor") ? 1 : 0);
		$vote->setVotedAgainst(($userVote == "votedAgainst") ? 1 : 0);
		$vote->setVotedBlank(($userVote == "votedBlank") ? 1 : 0);
		$vote->setUser($user);
		
		$entityManager->persist($vote);
		$entityManager->flush();

		$this->addFlash("success", "vote.success");

		return $this->redirectToRoute('proposal_index', [
					'slug'		 => $slug,
					'workshop'	 => $proposal->getWorkshop()->getId()
		]);
	}

	/**
	 * @Route("/{slug}/workshop/proposal/{proposal}/vote/delete/{vote}", name="vote_delete", methods={"GET"})
	 */
	public function delete(Request $request, Vote $vote): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($vote);
		$entityManager->flush();

		
		$this->addFlash("success", "delete.success");
		return $this->redirectToRoute('proposal_index', [
					'slug'		 => $slug,
					'workshop'	 => $vote->getProposal()->getWorkshop()
		]);
	}

}