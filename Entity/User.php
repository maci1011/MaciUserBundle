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
	 * @Assert\NotBlank(groups={"Registration","Profile"})
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/", message="validation.user.password.regex", groups={"Registration","Profile"})
	 */
	protected $username;

	/**
	 * @Assert\Length(
	 *     min=8,
	 *     max=100,
	 *     minMessage="validation.user.password.short",
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
}
