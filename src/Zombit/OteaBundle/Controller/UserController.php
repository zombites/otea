<?php

namespace Zombit\OteaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Model\UserManagerInterface;

use Zombit\OteaBundle\Form\Type\RegistrationFormType;
use Zombit\OteaBundle\Form\Type\ProfileFormType;

class UserController extends Controller
{
    public function listAction()
    {
    	if (!$this->get('security.context')->isGranted(new Expression('"ROLE_ADMIN" in roles or (user and user.isSuperAdmin())')))
		{
	        throw new AccessDeniedException();
	    }
		
		$user = $this->container->get('fos_user.user_manager')->createUser();
		
		$form = $this->createForm(new RegistrationFormType(), $user);
		
        $users = $this->container->get('fos_user.user_manager')->findUsers();

        return $this->render('ZombitOteaBundle:User:users.html.twig', array('users' => $users, 'form' => $form->createView(), 'active' => 2));
    }
	
	public function delAction($username)
	{
    	if (!$this->get('security.context')->isGranted(new Expression('"ROLE_ADMIN" in roles or (user and user.isSuperAdmin())')))
		{
	        throw new AccessDeniedException();
	    }
		
		$user = $this->container->get('fos_user.user_manager')->findUserByUsername($username);
		
		$this->container->get('fos_user.user_manager')->deleteUser($user);
		
		$users = $this->container->get('fos_user.user_manager')->findUsers();
		
		$route = 'zombit_otea_userspage';
		$url = $this->generateUrl($route);
		
		return $this->redirect($url);
		
	}
	
    public function addAction(Request $request)
	{
    	if (!$this->get('security.context')->isGranted(new Expression('"ROLE_ADMIN" in roles or (user and user.isSuperAdmin())')))
		{
	        throw new AccessDeniedException();
	    }
		
		if ('POST' === $request->getMethod()) {
			
		
			$user = $this->container->get('fos_user.user_manager')->createUser();
			$form = $this->createForm(new RegistrationFormType(), $user);
			
            $form->handleRequest($request);

            if ($form->isValid()) {
            	$user->setEnabled(true);
				$this->container->get('fos_user.user_manager')->updateUser($user);
            }
			
        }		
		
		$route = 'zombit_otea_userspage';
		$url = $this->generateUrl($route);
		
		return $this->redirect($url);
    }
	
	public function editAction($username = false, Request $request)
	{
    	if (!$this->get('security.context')->isGranted(new Expression('"ROLE_ADMIN" in roles or (user and user.isSuperAdmin())')))
		{
	        throw new AccessDeniedException();
	    }
		
		if ('GET' === $request->getMethod()) // Se usa GET para cargar el formulario de edición mediante jquery
		{

			$user = $this->container->get('fos_user.user_manager')->findUserByUsername($username);
			$form = $this->createForm(new ProfileFormType(), $user);
			return $this->render('ZombitOteaBundle:User:edit.html.twig', array('form' => $form->createView(), 'active' => 2));
			
		}
		elseif ('POST' === $request->getMethod()) 
		{
			
			/* TODO: Edición de usuarios */

			$user = $this->container->get('fos_user.user_manager')->findUserByUsername($request->get('zombit_user_profile')['username']);
			//$user = $this->container->get('fos_user.user_manager')->createUser();
			$form = $this->createForm(new ProfileFormType(), $user);

            $form->handleRequest($request);

            if ($form->isValid()) {
				$this->container->get('fos_user.user_manager')->updateUser($user);
				//$this->container->get('fos_user.user_manager')->reloadUser($user);
            }
        }		
		
		$route = 'zombit_otea_userspage';
		$url = $this->generateUrl($route);
		
		return $this->redirect($url);
    }
		
}