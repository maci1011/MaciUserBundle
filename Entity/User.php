<?php

namespace Maci\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 */
class User extends BaseUser
{
	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * @Assert\Length(min=7, max=31, minMessage="validation.user.username.too-short", maxMessage="validation.user.username.too-long", groups={"Registration","Profile"})
	 * @Assert\NotBlank(groups={"Registration","Profile"})
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/", message="validation.user.password.regex", groups={"Registration","Profile"})
	 */
	protected $username;

	/**
	 * @Assert\Length(
	 *     min=8,
	 *     max=100,
	 *     minMessage="validation.user.password.too-short",
	 *     maxMessage="validation.user.password.too-long",
	 *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}
	 * )
	 * @Assert\Regex(
	 *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,100}$/",
	 *     message="user.password.difficulty",
	 *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}
	 * )
	 */
	protected $plainPassword;

	/**
	 * @var \DateTime
	 */
	private $created;

	public function __construct()
	{
		parent::__construct();
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
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return User
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
	 * setCreatedValue
	 */
	public function setCreatedValue()
	{
		$this->created = new \DateTime();
	}
}
