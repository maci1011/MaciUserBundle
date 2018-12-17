<?php

namespace Maci\UserBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Maci\UserBundle\Entity\Address;
use Maci\UserBundle\Form\Type\AddressType;

class AddressServiceController extends Controller
{
    private $om;

    private $authorizationChecker;

    private $tokenStorage;

    private $user;

    private $session;

    private $list;

    public function __construct(ObjectManager $objectManager, AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, Session $session)
    {
        $this->om = $objectManager;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->list = false;
    }

    public function removeItem($id)
    {
        $address = $this->getAddress($id);

        if (
            !$address
        ) {
            return false;
        }

        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {
            $address->setRemoved(true);
            $this->om->flush();
        } else {
            $addresses = $this->session->get('addresses', array());
            array_splice($addresses, $id);
            $this->session->set('addresses', $addresses);
        }

        return true;
    }

    public function getAddress($id)
    {
        if (array_key_exists($id, $list = $this->getAddressList())) {
           return $list[$id];
        }
        return false;
    }

    public function getAddressList()
    {
        if ($this->list) {
            return $this->list;
        }
        $list = array();
        if (true === $this->authorizationChecker->isGranted('ROLE_USER')) {
            $list = $this->om->getRepository('MaciUserBundle:Address')
                ->findBy(array(
                    'user' => $this->tokenStorage->getToken()->getUser(),
                    'removed' => false
                ))
            ;
        } else {
            $addresses = $this->session->get('addresses', array());
            foreach ($addresses as $key => $adr) {
                $list[$key] = $this->getAddressFromArray($adr);
            }
        }
        return $this->list = $list;
    }

    public function getAddressChoices()
    {
        $choices = array();
        $list = $this->getAddressList();
        foreach ($list as $key => $value) {
            $choices[$value->getLabel()] = $key;
        }
        return $choices;
    }

    public function getAddressFromArray($adr)
    {
        $address = new Address;
        $address->setPrefix($adr['prefix']);
        $address->setName($adr['name']);
        $address->setSurname($adr['surname']);
        $address->setCompany($adr['company']);
        $address->setAddress($adr['address']);
        $address->setFloor($adr['floor']);
        $address->setCap($adr['cap']);
        $address->setCity($adr['city']);
        $address->setCountry($adr['country']);
        $address->setState($adr['state']);
        $address->setTelephon($adr['telephon']);
        $address->setMail($adr['mail']);
        $address->setInfo($adr['info']);
        return $address;
    }

    public function getArrayFromAddress($address)
    {
        return array(
            'prefix' => $address->getPrefix(),
            'name' => $address->getName(),
            'surname' => $address->getSurname(),
            'company' => $address->getCompany(),
            'address' => $address->getAddress(),
            'floor' => $address->getFloor(),
            'cap' => $address->getCap(),
            'city' => $address->getCity(),
            'country' => $address->getCountry(),
            'state' => $address->getState(),
            'telephon' => $address->getTelephon(),
            'mail' => $address->getMail(),
            'info' => $address->getInfo(),
        );
    }
}
