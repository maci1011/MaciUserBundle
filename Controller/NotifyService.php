<?php

namespace Maci\UserBundle\Controller;

use Maci\UserBundle\Entity\Notify;
use Maci\UserBundle\Entity\User;

class NotifyService extends Controller
{
	private $om;

	private $authorizationChecker;

	private $tokenStorage;

	private $user;

	public function __construct(
		ObjectManager $objectManager,
		AuthorizationCheckerInterface $authorizationChecker,
		TokenStorageInterface $tokenStorage,
		Session $session
	){
		$this->om = $objectManager;
		$this->authorizationChecker = $authorizationChecker;
		$this->tokenStorage = $tokenStorage;
		$this->user = $tokenStorage->getToken()->getUser();
	}

	public static function notify(string $message, string $type = 'd')
	{
		if (false === $this->authorizationChecker->isGranted('ROLE_USER'))
			return;

		$this->notifyTo($this->user, $message, $type);
	}

	public static function notifyTo(User $user, string $message, string $type = 'd')
	{
		$notify = new Notify();
		$notify->setUser($user);
		$notify->setText($message);
		$notify->setType($type);
		$this->om->persist($notify);
		$this->om->flush();
	}
}
