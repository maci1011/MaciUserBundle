<?php

namespace Maci\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Maci\UserBundle\Entity\Address;

use Maci\UserBundle\Form\Type\AddressType;

class AddressController extends Controller
{
	public function indexAction()
	{
		return $this->render('MaciUserBundle:Address:index.html.twig', array(
			'list' => $this->get('maci.addresses')->getAddressList()
		));
	}

	public function listAction(Request $request)
	{
		return $this->render('MaciUserBundle:Address:_list.html.twig', array(
			'list' => $this->get('maci.addresses')->getAddressList()
		));
	}

	public function addressFormAction(Request $request, $id)
	{
		return $this->form($request, $id, 'MaciUserBundle:Address:form.html.twig');
	}

	public function formAction(Request $request, $id)
	{
		return $this->form($request, $id, 'MaciUserBundle:Address:_form.html.twig');
	}

	public function removeAction(Request $request, $id)
	{
		if ( $this->get('maci.addresses')->removeItem(intval($id)) ) {
			return $this->redirect($this->generateUrl('maci_address', array('removed' => true)));
		} else {
			return $this->redirect($this->generateUrl('maci_address', array('error' => true)));
		}
	}

	public function form(Request $request, $id, $template)
	{
		if ($id === null) {
			$address = new Address();
		} else {
			$address = $this->get('maci.addresses')->getAddress(intval($id));
			if (!$address) {
				var_dump( array_keys($this->get('maci.addresses')->getAddressList()) );die();
				return false;
			}
		}

		$form = $this->createForm(AddressType::class, $address);
		$form->handleRequest($request);
		$method = ( $request->get('method') ? $request->get('method') : false );

		if ($form->isSubmitted() && $form->isValid()) {

			if (true === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
				$em = $this->getDoctrine()->getManager();
				if ($id === null) {
					$address->setUser($this->getUser());
					$em->persist($address);
				}
				$em->flush();
				$id = $address->getId();
			} else {
				$session = $this->get('session');
				$addresses = $session->get('addresses', array());
				$save = $this->get('maci.addresses')->getArrayFromAddress($address);
				if ($id === null) {
					$id = count($addresses);
				}
				$addresses[$id] = $save;
				$session->set('addresses', $addresses);
			}

			$method = $form['method']->getData();

			if ( $method === 'billing' ) {
				$this->get('maci.orders')->setCartBillingAddress($address);
				return $this->redirect($this->generateUrl('maci_order_gocheckout'));
			} else if ( $method === 'shipping' ) {
				$this->get('maci.orders')->setCartShippingAddress($address);
				return $this->redirect($this->generateUrl('maci_order_gocheckout'));
			}

			$message = ( $id === null ? 'add' : 'edit' );
			return $this->redirect($this->generateUrl('maci_address', array($message => true)));
		}

		return $this->render($template, array(
			'id' => $id,
			'address' => $address,
			'form' => $form->createView(),
			'method' => $method
		));
	}
}
