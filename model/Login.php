<?php

namespace model;

class Login {
	private $username;
	private $password;
	private $loginButton;
	private $logoutButton;
	private $keepMeLoggedInIsCheckbox;
	private $dbConnection;

	public function __construct() {
		$this->dbConnection = new DatabaseConnection();
		$this->dbConnection->connect();

		$this->username = $_POST['LoginView::UserName'];
		$this->password = $_POST['LoginView::Password'];
		$this->loginButton = $_POST['LoginView::Login'];
		$this->logoutButton = $_POST['LoginView::Logout'];
		$this->keepMeLoggedInIsCheckbox = $_POST['LoginView::KeepMeLoggedIn'];
	}

	public function response() {
		if($this->loginButtonIsPressed() && $this->usernameIsMissing()) {
			return "Username is missing";
		}
		if($this->loginButtonIsPressed() && !$this->usernameIsMissing() && $this->passwordIsMissing()) {
			return "Password is missing";
		}
		if($this->loginButtonIsPressed() && !$this->correspondUserNamePassword()) {
			return "Wrong name or password";
		}
		if($this->loginButtonIsPressed() && $this->correspondUserNamePassword() && !$this->keepMeLoggedInIsChecked() && $_SESSION['isLoggedIn'] == false) {
			$_SESSION['isLoggedIn'] = true;
			return "Welcome";
		}
		if($this->logInButtonIsPressed() && $_SESSION['isLoggedIn'] == true) {
			return null;
		}
		if($this->logOutButtonIsPressed()) {
			unset($_COOKIE['CookieName']);
			unset($_COOKIE['CookiePassword']);
		}
		if($this->logOutButtonIsPressed() && $_SESSION['isLoggedIn'] == true) {
			$_SESSION['isLoggedIn'] = false;
			return "Bye bye!";
		}
		if($this->logOutButtonIsPressed() && $_SESSION['isLoggedIn'] == false) {
			return null;
		}
		if($this->loginButtonIsPressed() && $this->correspondUserNamePassword() && $this->keepMeLoggedInIsChecked()) {
			$_SESSION['isLoggedIn'] = true;

			if($_COOKIE["CookieName"] == null || $_COOKIE['CookiePassword'] == null)  {
				$cookiePassword = $this->randomString();
				setcookie("CookieName", $this->username, $this->cookieTime());
				setcookie("CookiePassword", $cookiePassword, $this->cookieTime());
				$this->dbConnection->setCookieIdToMember($this->username, $cookiePassword);
			}
			return "Welcome and you will be remembered";
		}
		if($_COOKIE['CookieName'] !== null && $_COOKIE['CookiePassword'] !== null && $this->dbConnection->correspondCookieUsernamePassword($_COOKIE['CookieName'], $_COOKIE['CookiePassword'])) {
			if($_SESSION['isLoggedIn']) {
				return null;
			}
			$_SESSION['isLoggedIn'] = true;
			return "Welcome back with cookie";
		}
	}

	private function cookieTime() {
		$thirtyDaysInSeconds = 2592000;
		return time()+($thirtyDaysInSeconds);
	}

	private function correspondUserNamePassword() {
		return $this->dbConnection->correspondUsernamePassword($this->username, $this->password);
	}

	private function getUsers() {
		return $this->dbConnection->getAllRegisteredUsers();
	}

	private function loginButtonIsPressed() {
		if($this->loginButton !== null) {
			return true;
		}
		return false;
	}

	private function logoutButtonIsPressed() {
		if($this->logoutButton != null) {
			return true;
		}
		return false;
	}

	private function passwordIsMissing() {
		if($this->password == null) {
			return true;
		}
		return false;
	}

	private function randomString() {
		$salt1 = ")y%b[GH8;??AtN8ttkhi6vM9UugVKQ78JCgp2b6g?A?7o/$W6D";
		$salt2 = "KpGuNxZGF[Uh2qj423(2N=9;CEoK4]w}E@xgs.8TUfpp3Z%[L2";
		return crypt($salt1 . uniqid() . $salt2);
	}

	private function keepMeLoggedInIsChecked() {
		if($this->keepMeLoggedInIsCheckbox != null) {
			return true;
		}
		return false;
	}

	private function usernameExists($username) {
		return in_array($username, $this->getUsers());
	}

	private function usernameIsMissing() {
		if($this->username == null) {
			return true;
		}
		return false;
	}
}