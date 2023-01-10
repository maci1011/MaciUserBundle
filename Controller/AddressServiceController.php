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

	public static function getAddressFromArray($array)
	{
		if (!$array) return null;
		$address = new Address;
		$address->setPrefix($array['prefix']);
		$address->setName($array['name']);
		$address->setSurname($array['surname']);
		$address->setCompany($array['company']);
		$address->setAddress($array['address']);
		$address->setFloor($array['floor']);
		$address->setCap($array['cap']);
		$address->setCity($array['city']);
		$address->setCountry($array['country']);
		$address->setState($array['state']);
		$address->setTelephon($array['telephon']);
		$address->setInfo($array['info']);
		return $address;
	}

	public static function getArrayFromAddress($address)
	{
		if (!$address) return [];
		return [
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
			'info' => $address->getInfo(),
		];
	}
}
