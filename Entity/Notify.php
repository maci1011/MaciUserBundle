<?php

namespace Maci\UserBundle\Entity;

/**
 * Notify
 */
class Notify
{
	/**
	 * @var string(13)
	 */
	private $hash;

	/**
	 * @var char
	 */
	private $type;

	/**
	 * @var text
	 */
	private $text;

	/**
	 * @var json
	 */
	private $data;

	/**
	 * @var \DateTime
	 */
	private $created;

	/**
	 * @var \Maci\UserBundle\Entity\User
	 */
	private $user;


	public function __construct()
	{
		$this->hash = uniqid();
		$this->type = 'n';
	}


	/**
	 * Get hash
	 *
	 * @return string 
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * Set type
	 *
	 * @param string $type
	 * @return Notify
	 */
	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * Get type
	 *
	 * @return string 
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Get Type Array
	 */
	static public function getTypeArray()
	{
		return [
			'Author' => '_author',
			'Translator' => 'transla'
		];
	}

	public function getTypeLabel()
	{
		return \Maci\PageBundle\MaciPageBundle::getLabel($this->type, $this->getTypeArray());
	}

	static public function getTypes()
	{
		return array_values(Notify::getTypeArray());
	}

	/**
	 * Set data
	 *
	 * @param string $data
	 * @return Notify
	 */
	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Get data
	 *
	 * @return string 
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Notify
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
	 * Set user
	 *
	 * @param \Maci\UserBundle\Entity\User $user
	 * @return Notify
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

	public function getUsername()
	{
		return $this->user ? $this->user->getUsername() : null;
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
	public function __toString()
	{
		return 'Notify#' . $this->getHash();
	}
}
