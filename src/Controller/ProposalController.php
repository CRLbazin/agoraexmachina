<?php
namespace App\Controller;

use App\Entity\Proposal;
use App\Entity\Workshop;
use App\Entity\Category;
use App\Form\ProposalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProposalController extends AbstractController
{

	/**
	 * @Route("/{slug}/workshop/{workshop}/proposal/add", name="proposal_add", methods={"GET", "POST"})
	 */
	public function add(Request $request, string $slug, Workshop $workshop): Response
	{
		$proposal	 = new Proposal();
		$proposal->setUser($this->getUser());
		$proposal->setWorkshop($workshop);
		$form		 = $this->createForm(ProposalType::class, $proposal);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($proposal);
			$entityManager->flush();

			$this->addFlash("success", "add.success");
			return $this->redirectToRoute('proposal_index', ['slug' => $slug, 'workshop' => $workshop->getId()]);
		}

		return $this->render('proposal/add.html.twig', [
					'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
					'workshops'	 => $this->getDoctrine()->getRepository(Workshop::class)->findAll(),
					'workshop'	 => $workshop,
					'form'		 => $form->createView(),
		]);
	}

	/**
	 * @Route("/{slug}/workshop/{workshop}/proposal/{proposal}", name="proposal_index", methods={"GET"})
	 */
	public function index(Request $request, string $slug, Workshop $workshop, Proposal $proposal = null): Response
	{
		return $this->render('proposal/index.html.twig', [
					'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
					'workshops'	 => $this->getDoctrine()->getRepository(Workshop::class)->findAll(),
					'workshop'	 => $workshop,
					'proposals'	 => $this->getDoctrine()->getRepository(Proposal::class)->findBy(['workshop' => $workshop]),
					'proposal'	 => $proposal
		]);
	}

	/**
	 * @Route("/{slug}/workshop/{workshop}/proposal/{proposal}/edit", name="proposal_edit", methods={"GET", "POST"})
	 */
	public function edit(Request $request, string $slug, Proposal $proposal, Workshop $workshop): Response
	{
		$proposal->setUser($this->getUser());
		$proposal->setWorkshop($workshop);

		$form = $this->createForm(ProposalType::class, $proposal);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash("success", "edit.success");
			return $this->redirectToRoute('proposal_index', ['slug' => $slug, 'proposal' => $proposal->getId(), 'workshop' => $workshop->getId()]);
		}

		return $this->render('proposal/edit.html.twig', [
					'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
					'workshops'	 => $this->getDoctrine()->getRepository(Workshop::class)->findAll(),
					'workshop'	 => $workshop,
					'form'		 => $form->createView(),
		]);
	}

	/**
	 * @Route("/{slug}/workshop/{workshop}/proposal/delete/{proposal}", name="proposal_delete", methods={"GET"})
	 */
	public function delete(Request $request, string $slug, Workshop $workshop, Proposal $proposal): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($proposal);
		$entityManager->flush();

		$this->addFlash("success", "delete.success");
		return $this->redirectToRoute('proposal_index', ['slug' => $slug, 'workshop' => $workshop->getId()]);
	}

}