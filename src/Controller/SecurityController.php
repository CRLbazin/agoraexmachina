<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserEditFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
       
        return $this->render('security/login.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
	
	/**
	 * @Route("/admin/user", name="user_admin")
	 */
	public function admin()
	{
		$users = $this->getDoctrine()
				->getRepository(User::class)
				->findAll();
		
	    return $this->render('security/admin.html.twig',
				[
					'users' => $users
				]
				);		
	}
	
	/**
	 * @Route("/admin/user/delete/{id}", name="user_delete") 
	 */
	public function delete(int $id)
	{
		$user = $this->getDoctrine()
				->getRepository(User::class)
				->find($id);
		
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($user);
		$entityManager->flush();
		
		$this->addFlash("success", "delete.success");
		return $this->redirectToRoute('user_admin');
		
	}
	
	/**
	 * @Route("/admin/user/edit/{id}", name="user_admin_edit")
	 */
	public function edit(Request $request, int $id)
	{
		$user = $this->getDoctrine()
				->getRepository(User::class)
				->find($id);
		
		$form = $this->createForm(UserEditFormType::class, $user);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) 
		{
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
			
			$this->addFlash("success", "edit.success");
		}

		
        return $this->render('security/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
	}
	
	/**
	 * @Route("/register", name="app_register")
	 */
	public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
