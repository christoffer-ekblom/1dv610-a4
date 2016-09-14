<?php

namespace model;

class Login {
	private $isLoggedIn = false;
	private $username;
	private $password;
	private $loginButton;

	public function __construct() {
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
		if($this->loginButtonIsPressed() && !$this->usernameIsMissing && $this->passwordIsMissing()) {
			return "Password is missing";
		}
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

	private function usernameIsMissing() {
		if($this->username == null) {
			return true;
		}
		return false;
	}
}