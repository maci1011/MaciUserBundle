<?php

namespace Maci\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class UserMenuBuilder
{
	private $factory;

	private $securityContext;

	private $user;

	public function __construct(FactoryInterface $factory, SecurityContext $securityContext)
	{
	    $this->factory = $factory;
	    $this->securityContext = $securityContext;
	    $this->user = $securityContext->getToken()->getUser();
	}

    public function createUserMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

		if ($request->getLocale() !== 'it') {

			$menu->addChild('IT', array('route' => $request->get('_route'), 'routeParameters' => array_merge($request->get('_route_params'), array('_locale' => 'it'))));

		}

		if ($request->getLocale() !== 'en') {

			$menu->addChild('EN', array('route' => $request->get('_route'), 'routeParameters' => array_merge($request->get('_route_params'), array('_locale' => 'en'))));

		}

        if (true === $this->securityContext->isGranted('ROLE_USER')) {

	        $uname = $this->user->getUsername();

			$menu->addChild($uname)->setAttribute('dropdown', true);

        	$this->addDefaultsLink($menu[$uname]);

			$menu->addChild('Cart', array('route' => 'maci_order_cart'));

			$menu->addChild('Logout', array('route' => 'fos_user_security_logout'));

        } else {

			$menu->addChild('Login', array('route' => 'fos_user_security_login'));

			$menu->addChild('Register', array('route' => 'fos_user_registration_register'));

        }

		return $menu;
	}

    public function createLeftMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

        if (true === $this->securityContext->isGranted('ROLE_USER')) {

        	$this->addDefaultsLink($menu);

        } else {

			$menu->addChild('Login', array('route' => 'fos_user_security_login'));

			$menu->addChild('Register', array('route' => 'fos_user_registration_register'));

			$menu->addChild('Change Password', array('route' => 'fos_user_resetting_request'));

        }

		return $menu;
	}

    public function addDefaultsLink($menu)
	{
        if (true === $this->securityContext->isGranted('ROLE_ADMIN')) {

			$menu->addChild('Administration', array('route' => 'maci_admin'));

        }

		$menu->addChild('Dashboard', array('route' => 'maci_user'));

		$menu->addChild('Profile', array('route' => 'maci_user_profile'));

		$menu->addChild('My Cart', array('route' => 'maci_order_cart'));

		$menu->addChild('My Orders', array('route' => 'maci_order'));

		$menu->addChild('My Library', array('route' => 'maci_user_library'));

		$menu->addChild('My Addresses', array('route' => 'maci_address'));
	}
}
