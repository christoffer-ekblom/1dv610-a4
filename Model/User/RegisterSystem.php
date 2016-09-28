<?php

namespace Model\User;

require_once('Model/User/MemberRegistry.php');

require_once('Exceptions/RegisterWithoutAnyInformationException.php');
require_once('Exceptions/RegisterWithEmptyPasswordsException.php');
require_once('Exceptions/RegisterWithAShortUsernameException.php');
require_once('Exceptions/RegisterWithAShortPasswordException.php');
require_once('Exceptions/RegisterWithADifferentPasswordsException.php');
require_once('Exceptions/RegisterWithAnExistingUserException.php');
require_once('Exceptions/RegisterWithNotAllowedCharactersException.php');

class RegisterSystem {
	private $member;
	private $canRegister;

	public function __construct() {
		$this->member = new MemberRegistry();
		$this->canRegister = false;
	}

	public function register(Credentials $credentials) {
		$this->member->registerUser($credentials);
	}

	public function validateCredentials($username, $password, $passwordRepeat) {
		$usernameMinLength = 3;
		$passwordMinLength = 6;

		$registerWithoutAnyInformation = $username == '' && $password == null && $passwordRepeat == null;
		$registerWithEmptyPasswords = $username != '' && $password == null && $passwordRepeat == null;
		$registerWithAShortUsername = strlen($username) < $usernameMinLength && strlen($password) >= $passwordMinLength && strlen($passwordRepeat) >= $passwordMinLength;
		$registerWithAShortPassword = strlen($username) >= $usernameMinLength && strlen($password) < $passwordMinLength && strlen($passwordRepeat) < $passwordMinLength;
		$registerWithADifferentPasswords = $password !== $passwordRepeat;
		$memberAlreadyExists = $this->member->usernameExists($username);
		$registerWithNotAllowedCharacters = $username != strip_tags($username);

		if($registerWithoutAnyInformation) {
			throw new \RegisterWithoutAnyInformationException();	
		}
		elseif($registerWithEmptyPasswords) {
			throw new \RegisterWithEmptyPasswordsException();
		}
		elseif($registerWithAShortUsername) {
			throw new \RegisterWithAShortUsernameException();
		}
		elseif($registerWithAShortPassword) {
			throw new \RegisterWithAShortPasswordException();
		}
		elseif($registerWithADifferentPasswords) {
			throw new \RegisterWithADifferentPasswordsException();
		}
		elseif($memberAlreadyExists) {
			throw new \RegisterWithAnExistingUserException();
		}
		elseif($registerWithNotAllowedCharacters) {
			throw new \RegisterWithNotAllowedCharactersException();
		}
		else {
			$this->canRegister = true;
		}
	}

	public function canRegister() {
		return $this->canRegister;
	}
}