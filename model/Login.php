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
		if($this->loginButtonIsPressed() && $this->correspondUserNamePassword() && !$this->keepMeLoggedInIsChecked()) {
			$_SESSION['isLoggedIn'] = true;
			return "Welcome";
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
			setcookie("CookieName", $this->username, $this->cookieTime());
			setcookie("CookiePassword", $this->hashedPassword(), $this->cookieTime());
			return "Welcome and you will be remembered";
		}
	}

	private function cookieTime() {
		return time()+(60*60*24*30);
	}

	private function correspondUserNamePassword() {
		return $this->dbConnection->correspondUsernamePassword($this->username, $this->password);
	}

	private function hashedPassword() {
		$options = ['cost' => 12,];
		return password_hash($this->password, PASSWORD_BCRYPT, $options);
	}

	private function getUsers() {
		return $this->dbConnection->getAllRegisteredUsers();
	}

	private function loginButtonIsPressed() {
		if($this->loginButton != null) {
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