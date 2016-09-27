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

	public function validateCredentials($username, $password, $passwordRepeat) {
		$registerWithoutAnyInformation = $username == '' && $password == null && $passwordRepeat == null;
		$registerWithEmptyPasswords = $username != '' && $password == null && $passwordRepeat == null;

		if($registerWithoutAnyInformation) {
			throw new \RegisterWithoutAnyInformationException();	
		}
		if($registerWithEmptyPasswords) {
			throw new \RegisterWithEmptyPasswordsException();
		}
	}
}