<?php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryController extends AbstractController
{

	/**
	 * @Route("/admin/category", name="category_admin", methods={"GET"})
	 */
	public function admin(): Response
	{
		return $this->render('category/admin.html.twig', [
					'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
		]);
	}

	/**
	 * @Route("/admin/category/add", name="category_add", methods={"GET", "POST"})
	 */
	public function add(Request $request): Response
	{
		$category	 = new Category();
		$form		 = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($category);
			$entityManager->flush();

			$this->addFlash("success", "add.success");
			return $this->redirectToRoute('category_edit', ["category" => $category->getId()]);
		}

		return $this->render('category/add.html.twig', [
					'form'		 => $form->createView()
		]);
	}

	/**
	 * @Route("/admin/category/edit/{category}", name="category_edit", methods={"GET", "POST"})
	 */
	public function edit(Request $request, Category $category): Response
	{
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$this->getDoctrine()->getManager()->flush();
			
			$this->addFlash("success", "edit.success");
		}

		return $this->render('category/edit.html.twig', [
					'form'		 => $form->createView(),
					'category'	 => $category
		]);
	}

	/**
	 * @Route("/admin/category/delete/{category}", name="category_delete", methods={"GET"})
	 */
	public function delete(Request $request, Category $category): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($category);
		$entityManager->flush();
		
		$this->addFlash("success", "delete.success");
		return $this->redirectToRoute('category_admin');
	}

}