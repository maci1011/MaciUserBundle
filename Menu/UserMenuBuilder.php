<?php

namespace Maci\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Common\Persistence\ObjectManager;

use Maci\TranslatorBundle\Controller\TranslatorController;

class UserMenuBuilder
{
	private $factory;

	private $securityContext;

	private $user;

	private $translator;

	private $locales;

	public function __construct(FactoryInterface $factory, SecurityContext $securityContext, ObjectManager $om, TranslatorController $tc)
	{
	    $this->factory = $factory;
	    $this->securityContext = $securityContext;
	    $this->om = $om;
	    $this->user = $securityContext->getToken()->getUser();
	    $this->translator = $tc;
	    $this->locales = $tc->getLocales();
	}

    public function createLanguageMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav');

		foreach ($this->locales as $locale) {

			$label = strtoupper($locale);

			$menu->addChild($label, array('route' => $request->get('_route'), 'routeParameters' => array_merge($request->get('_route_params'), array('_locale' => $locale))));

			if ($request->getLocale() === $locale) {

				$menu[$label]->setCurrent(true);

			}
			
		}

		return $menu;
	}

    public function createUserMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if (true === $this->securityContext->isGranted('ROLE_USER')) {

	        $uname = $this->user->getUsername();

			$menu->addChild($uname)->setAttribute('dropdown', true);

        	$this->addDefaultsLink($menu[$uname]);

        	$logoutLabel = $this->translator->getText('menu.user.logout', 'Logout');

        	$menu[$uname]->addChild($logoutLabel, array('route' => 'fos_user_security_logout'));

			$menu[$uname][$logoutLabel]->setAttribute('divider_prepend', true);

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

			$menu->addChild($this->translator->getText('menu.user.register', 'Register'), array('route' => 'maci_user_register'));

        }

		$menu->addChild($this->translator->getText('menu.cart', 'Cart'), array('route' => 'maci_order_cart'));

		return $menu;
	}

    public function createLeftMenu(Request $request)
	{
		$menu = $this->factory->createItem('root');

        if (true === $this->securityContext->isGranted('ROLE_USER')) {

        	$this->addDefaultsLink($menu);

        } else {

			$menu->addChild($this->translator->getText('menu.user.login', 'Login'), array('route' => 'maci_user_login'));

			$menu->addChild($this->translator->getText('menu.user.register', 'Register'), array('route' => 'maci_user_register'));

			$menu->addChild($this->translator->getText('menu.user.change_password', 'Change Password'), array('route' => 'fos_user_resetting_request'));

        }

		return $menu;
	}

    public function addDefaultsLink($menu)
	{
        if (true === $this->securityContext->isGranted('ROLE_ADMIN')) {

        	$adminLabel = $this->translator->getText('menu.user.administration', 'Administration');

			$menu->addChild($adminLabel, array('route' => 'maci_admin'));

			$menu[$adminLabel]->setAttribute('divider_append', true);

        }

		$menu->addChild($this->translator->getText('menu.user.dashboard', 'Dashboard'), array('route' => 'maci_user'));

		$menu->addChild($this->translator->getText('menu.user.profile', 'Profile'), array('route' => 'maci_user_profile'));

		$menu->addChild($this->translator->getText('menu.user.cart', 'My Cart'), array('route' => 'maci_order_cart'));

		$menu->addChild($this->translator->getText('menu.user.order', 'My Orders'), array('route' => 'maci_order'));

		$menu->addChild($this->translator->getText('menu.user.library', 'My Library'), array('route' => 'maci_user_library'));

		$menu->addChild($this->translator->getText('menu.user.address', 'My Addresses'), array('route' => 'maci_address'));
	}
}
