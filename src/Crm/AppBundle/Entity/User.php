<?php

namespace Crm\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
	protected $firstName;

	protected $lastName;

	public function __construct()
	{
		parent::__construct();
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setFirstName($first_name)
	{
		$this->firstName = $first_name;

		return $this;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function setLastName($last_name)
	{
		$this->lastName = $last_name;

		return $this;
	}
}