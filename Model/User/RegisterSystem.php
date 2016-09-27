<?php

namespace Model\User;

require_once('Model/User/MemberRegistry.php');

require_once('Exceptions/RegisterWithoutAnyInformationException.php');
require_once('Exceptions/RegisterWithEmptyPasswordsException.php');
require_once('Exceptions/RegisterWithAShortUsernameException.php');
require_once('Exceptions/RegisterWithAShortPasswordException.php');
require_once('Exceptions/RegisterWithADifferentPasswordsException.php');

class RegisterSystem {
	private $member;

	public function __construct() {
		$this->member = new MemberRegistry();
	}
}