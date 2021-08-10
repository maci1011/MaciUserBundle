<?php

namespace Maci\UserBundle\Entity;

use Symfony\Component\Intl\Intl;

/**
 * Address
 */
class Address
{
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var string
	 */
	private $prefix;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $surname;

	/**
	 * @var string
	 */
	private $company;

	/**
	 * @var string
	 */
	private $address;

	/**
	 * @var string
	 */
	private $floor;

	/**
	 * @var string
	 */
	private $cap;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var string
	 */
	private $state;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $telephon;

	/**
	 * @var string
	 */
	private $info;

	/**
	 * @var \DateTime
	 */
	private $created;

	/**
	 * @var \DateTime
	 */
	private $updated;

	/**
	 * @var boolean
	 */
	private $removed;

	/**
	 * @var \Maci\UserBundle\Entity\User
	 */
	private $user;


	public function __construct()
	{
		$this->status = 'new';
		$this->removed = false;
	}


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set status
	 *
	 * @param string $status
	 * @return Address
	 */
	public function setStatus($status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * Get status
	 *
	 * @return string 
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set prefix
	 *
	 * @param string $prefix
	 * @return Address
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	/**
	 * Get prefix
	 *
	 * @return string 
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Address
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string 
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set surname
	 *
	 * @param string $surname
	 * @return Address
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;

		return $this;
	}

	/**
	 * Get surname
	 *
	 * @return string 
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * Set company
	 *
	 * @param string $company
	 * @return Address
	 */
	public function setCompany($company)
	{
		$this->company = $company;

		return $this;
	}

	/**
	 * Get company
	 *
	 * @return string 
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * Set address
	 *
	 * @param string $address
	 * @return Address
	 */
	public function setAddress($address)
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * Get address
	 *
	 * @return string 
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * Set floor
	 *
	 * @param string $floor
	 * @return Address
	 */
	public function setFloor($floor)
	{
		$this->floor = $floor;

		return $this;
	}

	/**
	 * Get floor
	 *
	 * @return string 
	 */
	public function getFloor()
	{
		return $this->floor;
	}

	/**
	 * Set cap
	 *
	 * @param string $cap
	 * @return Address
	 */
	public function setCap($cap)
	{
		$this->cap = $cap;

		return $this;
	}

	/**
	 * Get cap
	 *
	 * @return string 
	 */
	public function getCap()
	{
		return $this->cap;
	}

	/**
	 * Set city
	 *
	 * @param string $city
	 * @return Address
	 */
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * Get city
	 *
	 * @return string 
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Set state
	 *
	 * @param string $state
	 * @return Address
	 */
	public function setState($state)
	{
		$this->state = $state;

		return $this;
	}

	/**
	 * Get state
	 *
	 * @return string 
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Set country
	 *
	 * @param string $country
	 * @return Address
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Get country
	 *
	 * @return string 
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Get country
	 *
	 * @return string 
	 */
	public function getCountryName()
	{
		return Intl::getRegionBundle()->getCountryName( $this->country );
	}

	/**
	 * Set telephon
	 *
	 * @param string $telephon
	 * @return Address
	 */
	public function setTelephon($telephon)
	{
		$this->telephon = $telephon;

		return $this;
	}

	/**
	 * Get telephon
	 *
	 * @return string 
	 */
	public function getTelephon()
	{
		return $this->telephon;
	}

	/**
	 * Set info
	 *
	 * @param string $info
	 * @return Address
	 */
	public function setInfo($info)
	{
		$this->info = $info;

		return $this;
	}

	/**
	 * Get info
	 *
	 * @return string 
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Address
	 */
	public function setCreated($created)
	{
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return \DateTime 
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * Set updated
	 *
	 * @param \DateTime $updated
	 * @return Address
	 */
	public function setUpdated($updated)
	{
		$this->updated = $updated;

		return $this;
	}

	/**
	 * Get updated
	 *
	 * @return \DateTime 
	 */
	public function getUpdated()
	{
		return $this->updated;
	}

	public function setRemoved($removed)
	{
		$this->removed = $removed;

		return $this;
	}

	public function getRemoved()
	{
		return $this->removed;
	}

	/**
	 * Set user
	 *
	 * @param \Maci\UserBundle\Entity\User $user
	 * @return Address
	 */
	public function setUser(\Maci\UserBundle\Entity\User $user = null)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \Maci\UserBundle\Entity\User 
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * setUpdatedValue
	 */
	public function setUpdatedValue()
	{
		$this->created = new \DateTime();
	}

	/**
	 * setCreatedValue
	 */
	public function setCreatedValue()
	{
		$this->updated = new \DateTime();
	}

	/**
	 * __toString()
	 */
	public function getLabel()
	{
		return ( $this->getPrefix().' '.$this->getName().' '.$this->getSurname().' - '.$this->getAddress().' - '.$this->getCity().', '.$this->getState().' - '.$this->getCountryName() );
	}

	/**
	 * __toString()
	 */
	public function __toString()
	{
		return $this->getLabel();
	}
}
