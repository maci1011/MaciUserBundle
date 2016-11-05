<?php

namespace Maci\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Maci\UserBundle\Entity\Address;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('maci_user_profile'));
        // return $this->render('MaciUserBundle:Default:index.html.twig');
    }

    public function loginAction()
    {
        return $this->render('MaciUserBundle:Default:login.html.twig');
    }

    public function registerAction()
    {
        return $this->render('MaciUserBundle:Default:register.html.twig');
    }
}
