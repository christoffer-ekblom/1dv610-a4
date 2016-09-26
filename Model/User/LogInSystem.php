<?php

namespace Model\User;

require_once('Model/User/MemberRegistry.php');
require_once('Model/User/Cookie.php');

require_once('Exceptions/LoginWithoutAnyEnteredFieldsException.php');
require_once('Exceptions/LoginWithOnlyUsernameException.php');
require_once('Exceptions/LoginWithOnlyPasswordException.php');
require_once('Exceptions/WrongNameOrPasswordException.php');

class LoginSystem {
	private $credentials;
	private $member;
	private $validLogin;
	private $usernameCookie;
	private $passwordCookie;
	private $cookieIsSet = false;

	public function __construct() {
		$this->member = new MemberRegistry();
	}

	public function setCredentials() {
		$this->credentials = $credentials;
	}

	public function validateCredentials(Credentials $credentials) {
		$username = $credentials->getUsername();
		$password = $credentials->getPassword();

		$usernameAndPasswordIsNull = $username == null && $password == null;
		$passwordIsNull = $username != null && $password == null;
		$usernameIsNull = $username == null && $password != null;

		if($usernameAndPasswordIsNull) {
			throw new \LoginWithoutAnyEnteredFieldsException();
		}
		elseif($passwordIsNull) {
			throw new \LoginWithOnlyUsernameException();
		}
		elseif($usernameIsNull) {
			throw new \LoginWithOnlyPasswordException();
		}
		elseif(!$this->member->usernamePasswordMatch($credentials)) {
			throw new \WrongNameOrPasswordException();
		}
		else {
			$this->validLogin = true;
		}
	}

	public function cookieLogin($username) {
		if(isset($_COOKIE['LoginView::CookiePassword'])) {
			$this->member->usernameCookieMatch($username, $_COOKIE['LoginView::CookiePassword']);
			$this->validLogin = true;
			$this->logIn();
			return true;
		}
		return false;
	}

	public function logIn() {
		if($this->validLogin) {
			$_SESSION['isLoggedIn'] = true;
			return true;
		}
		return false;
	}

	public function logout() {
		$_SESSION['isLoggedIn'] = null;
		setcookie('LoginView::CookieName', '', time()-3600);
		setcookie('LoginView::CookiePassword', '', time()-3600);
	}

	public function isLoggedIn() {
		if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true) {
			return true;
		}
		return false;
	}

	public function keepLogIn($username) {
		$this->cookieIsSet = true;
		$passwordValue = uniqid();

		$usernameCookie = new Cookie("LoginView::CookieName", $username);
		$passwordCookie = new Cookie("LoginView::CookiePassword", $passwordValue);

		$this->member->updateCookie($username, $passwordValue);
	}

	public function cookieIsSet() {
		return $this->cookieIsSet;
	}
}