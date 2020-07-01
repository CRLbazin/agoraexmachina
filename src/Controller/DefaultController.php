<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Workshop;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * @Route("/", name="homepage", methods={"GET"});
	 */
	public function index()
	{
		return $this->render('index.html.twig', [
				'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
		]);
	}

	/**
	 * @Route("/admin", name="admin", methods={"GET"});
	 */
	public function admin()
	{

		return $this->render('admin.html.twig', [
				'users'		 => $this->getDoctrine()->getRepository(User::class)->findAll(),
				'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
				'workshops'	 => $this->getDoctrine()->getRepository(Workshop::class)->findAll(),
		]);
	}

}