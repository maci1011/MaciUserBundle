<?php

namespace Maci\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('fos_user_profile_show'));
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
