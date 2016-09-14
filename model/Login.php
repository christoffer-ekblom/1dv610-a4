<?php

namespace model;

class Login {
	private $isLoggedIn = false;

	public function isLoggedIn() {
		return $this->isLoggedIn;
	}
}