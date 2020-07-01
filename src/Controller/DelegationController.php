<?php

namespace App\Controller;

use App\Entity\Delegation;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Workshop;
use App\Form\DelegationCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DelegationController extends AbstractController
{

	/**
	 * @Route("/user/delegation/", name="delegation_index", methods={"GET"})
	 */
	public function index(Request $request): Response
	{
		return $this->render('delegation/index.html.twig', [
				'delegationsFrom'	 => $this->getDoctrine()->getRepository(Delegation::class)->FindBy(
					[
						'userFrom' => $this->getUser(),
					]
				),
				'delegationsTo'		 => $this->getDoctrine()->getRepository(Delegation::class)->FindBy(
					[
						'userTo' => $this->getUser(),
					]
				),
		]);
	}

	/**
	 * @Route("/delegation/category/{category}/add", name="delegation_add_category", methods={"GET", "POST"})
	 */
	public function addCategory(Request $request, Category $category): Response
	{
		$entityManager = $this->getDoctrine()->getManager();

		$delegation = $entityManager->getRepository(Delegation::Class)->findOneBy(
			[
				'userFrom'	 => $this->getUser(),
				'category'	 => $category
		]);

		//case insert
		if (!$delegation)
			$delegation = new Delegation();


		$delegation->setUserFrom($this->getUser());
		$delegation->setCategory($category);

		$form = $this->createForm(DelegationCategoryType::class, $delegation);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($delegation);
			$entityManager->flush();

			$this->addFlash("success", "add.success");
			return $this->redirectToRoute('delegation_index');
		}

		return $this->render('delegation/add.category.html.twig', [
				'form' => $form->createView()
		]);
	}
	
	
	/**
	 * @Route("/delegation/workshop/{workshop}/add", name="delegation_add_workshop", methods={"GET", "POST"})
	 */
	public function addWorkshop(Request $request, Workshop $workshop): Response
	{
		$entityManager = $this->getDoctrine()->getManager();

		$delegation = $entityManager->getRepository(Delegation::Class)->findOneBy(
			[
				'userFrom'	 => $this->getUser(),
				'workshop'	 => $workshop
		]);

		//case insert
		if (!$delegation)
			$delegation = new Delegation();


		$delegation->setUserFrom($this->getUser());
		$delegation->setWorkshop($workshop);

		$form = $this->createForm(DelegationWorkshopType::class, $delegation);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($delegation);
			$entityManager->flush();

			$this->addFlash("success", "add.success");
			return $this->redirectToRoute('delegation_index');
		}

		return $this->render('delegation/add.workshop.html.twig', [
				'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/user/delegation/delete/{delegation}", name="delegation_delete", methods={"GET"})
	 */
	public function delete(Request $request, Delegation $delegation): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($delegation);
		$entityManager->flush();

		$this->addFlash("success", "delete.success");
		return $this->redirectToRoute('delegation_index');
	}

}