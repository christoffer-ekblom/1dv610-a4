<?php

namespace model;

class Login {
	private $isLoggedIn = false;
	private $username;
	private $password;
	private $loginButton;
	private $dbConnection;

	public function __construct() {
		$this->dbConnection = new DatabaseConnection();
		$this->dbConnection->connect();

		$this->username = $_POST['LoginView::UserName'];
		$this->password = $_POST['LoginView::Password'];
		$this->loginButton = $_POST['LoginView::Login'];
	}

	public function isLoggedIn() {
		return $this->isLoggedIn;
	}

	public function response() {
		if($this->loginButtonIsPressed() && $this->usernameIsMissing() && $this->passwordIsMissing()) {
			return "Username is missing";
		}
		if($this->loginButtonIsPressed() && !$this->usernameIsMissing() && $this->passwordIsMissing()) {
			return "Password is missing";
		}
		if($this->loginButtonIsPressed() && $this->usernameIsMissing() && !$this->passwordIsMissing()) {
			return "Username is missing";
		}
		if($this->usernameExists()) {
			return "Wrong name or password";
		}
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

	private function passwordIsMissing() {
		if($this->password == null) {
			return true;
		}
		return false;
	}

	private function usernameExists() {
		return in_array($this->username, $this->getUsers());
	}

	private function usernameIsMissing() {
		if($this->username == null) {
			return true;
		}
		return false;
	}
}