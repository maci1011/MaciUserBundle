<?php

namespace Maci\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
	public function indexAction()
	{
		return $this->redirect($this->generateUrl('fos_user_profile_show'));
	}

	public function loginAction()
	{
		$user = $this->getUser();
		if (is_object($user) && $user instanceof UserInterface)
			return $this->redirect($this->generateUrl('maci_user'));

		return $this->redirect($this->generateUrl('fos_user_security_login'));
	}

	public function registerAction()
	{
		$user = $this->getUser();
		if (is_object($user) && $user instanceof UserInterface)
			return $this->redirect($this->generateUrl('maci_user'));

		return $this->redirect($this->generateUrl('fos_user_registration_register'));
	}

	public function deleteAccountAction()
	{
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface)
			throw new AccessDeniedException('This user does not have access to this section.');

		return $this->render('@MaciUser/Default/delete.html.twig');
	}

	public function confirmDeleteAccountAction()
	{
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface)
			throw new AccessDeniedException('This user does not have access to this section.');

		$this->get('maci.mailer')->removeSubscription($user);

		$un = $user->getUsername() . '_del_' . uniqid();
		$user->setUsername($un)->setUsernameCanonical($un)->setEmail('null')->setEnabled(false)->setPassword(0)->setSalt(0);

		$this->getDoctrine()->getManager()->flush();

		return $this->redirect($this->generateUrl('fos_user_security_logout'));
	}

	public function newsletterAction()
	{
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface)
			throw new AccessDeniedException('This user does not have access to this section.');

		$subscription = $this->get('maci.mailer')->getSubscription($user);

		return $this->render('MaciUserBundle:Default:newsletter.html.twig', [
			'subscription' => $subscription,
			'user' => $user
		]);
	}

	public function notifiesAction()
	{
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface)
			throw new AccessDeniedException('This user does not have access to this section.');

		return $this->render('MaciUserBundle:notifies:newsletter.html.twig');
	}
}
