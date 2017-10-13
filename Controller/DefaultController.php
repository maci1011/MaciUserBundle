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

    public function deleteAccountAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('MaciUserBundle:Default:delete.html.twig');
    }

    public function confirmDeleteAccountAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $un = $user->getUsername() . '_del_' . uniqid();
        $user->setUsername($un)->setUsernameCanonical($un)->setEmail('null')->setEnabled(false)->setPassword(0)->setSalt(0);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }
}
