<?php

namespace Model\User;

class Cookie {
	private $name;
	private $value;
	private $time;

	public function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
		$this->time = $this->time();

		setcookie($this->name, $this->value, $this->time);
	}

	public function delete() {
		if(isset($_COOKIE[$this->name])) {
			$_COOKIE[$this->name] = null;
		}
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}

	private function time($seconds = 60*60*24*30) { // 30 days as default
		return time() + $seconds;
	}
}
