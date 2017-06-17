<?php

namespace Maci\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Maci\TranslatorBundle\Controller\TranslatorController;

class UserMenuBuilder
{
	private $factory;

	private $authorizationChecker;

	private $tokenStorage;

	private $user;

    private $request;

	private $translator;

	private $locales;

	public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, RequestStack $requestStack, TranslatorController $tc)
	{
	    $this->factory = $factory;
	    $this->authorizationChecker = $authorizationChecker;
	    $this->tokenStorage = $tokenStorage;
	    $this->user = $tokenStorage->getToken()->getUser();
        $this->request = $requestStack->getCurrentRequest();
	    $this->translator = $tc;
	    $this->locales = $tc->getLocales();
	}

    public function createLanguageMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav');

		foreach ($this->locales as $locale) {

			$label = strtoupper($locale);

			$menu->addChild($label, array('route' => $this->request->get('_route'), 'routeParameters' => array_merge($this->request->get('_route_params'), array('_locale' => $locale))));

			if ($this->request->getLocale() === $locale) {

				$menu[$label]->setCurrent(true);

			}

		}

		return $menu;
	}

    public function createUserMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {

	        $uname = $this->user->getUsername();

			$menu->addChild($uname)->setExtra('dropdown', true);

        	$this->addDefaultsLink($menu[$uname]);

        	$logoutLabel = $this->translator->getText('menu.user.logout', 'Logout');

        	$menu[$uname]->addChild($logoutLabel, array('route' => 'fos_user_security_logout'));

			$menu[$uname][$logoutLabel]->setExtra('divider_prepend', true);

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

			$menu->addChild($this->translator->getText('menu.user.register', 'Register'), array('route' => 'maci_user_register'));

        }

		return $menu;
	}

    public function createCartMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

		$menu->addChild($this->translator->getText('menu.cart', 'Cart'), array('route' => 'maci_order_cart'));

		return $menu;
	}

    public function createLeftMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav');

        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {

        	$this->addDefaultsLink($menu);

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

        }

		return $menu;
	}

    public function createLeftWithRegMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav');

        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {

        	$this->addDefaultsLink($menu);

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

			$menu->addChild($this->translator->getText('menu.user.register', 'Register'), array('route' => 'maci_user_register'));

			$menu->addChild($this->translator->getText('menu.user.change_password', 'Change Password'), array('route' => 'fos_user_resetting_request'));

        }

		return $menu;
	}

    public function createShortMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav');

        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {

			$menu->addChild($this->translator->getText('menu.user.profile', 'Profile'), array('route' => 'fos_user_profile_show'));

			$menu->addChild($this->translator->getText('menu.user.order', 'My Orders'), array('route' => 'maci_order'));

			$menu->addChild($this->translator->getText('menu.user.address', 'My Addresses'), array('route' => 'maci_address'));

        	$menu->addChild($this->translator->getText('menu.user.logout', 'Logout'), array('route' => 'fos_user_security_logout'));

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

			$menu->addChild($this->translator->getText('menu.user.register', 'Register'), array('route' => 'maci_user_register'));

			$menu->addChild($this->translator->getText('menu.user.change_password', 'Change Password'), array('route' => 'fos_user_resetting_request'));

			$menu->addChild($this->translator->getText('menu.user.order', 'My Orders'), array('route' => 'maci_order'));

        }

		return $menu;
	}

    public function addDefaultsLink($menu)
	{
        if (true === $this->authorizationChecker->isGranted('ROLE_ADMIN')) {

			$menu->addChild($this->translator->getText('menu.admin.administration', 'Administration'), array('route' => 'maci_admin'));

			$menu->addChild($this->translator->getText('menu.admin.confirmed_orders', 'Confirmed Orders'), array('route' => 'maci_order_admin_confirmed'));

        	$lastLabel = $this->translator->getText('menu.admin.mailer', 'Mailer');

			$menu->addChild($lastLabel, array('route' => 'maci_mailer'));

			$menu[$lastLabel]->setExtra('divider_append', true);

        }

		// $menu->addChild($this->translator->getText('menu.user.dashboard', 'Dashboard'), array('route' => 'maci_user'));

		$menu->addChild($this->translator->getText('menu.user.profile', 'Profile'), array('route' => 'fos_user_profile_show'));

		$menu->addChild($this->translator->getText('menu.user.address', 'Addresses'), array('route' => 'maci_address'));

		$menu->addChild($this->translator->getText('menu.user.order', 'Orders'), array('route' => 'maci_order'));

		$menu->addChild($this->translator->getText('menu.user.library', 'Library'), array('route' => 'maci_user_library'));

		$menu->addChild($this->translator->getText('menu.user.notifications', 'Notifications'), array('route' => 'maci_mailer_user_mails'));
	}
}
