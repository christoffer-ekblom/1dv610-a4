<?php

namespace model;

class DatabaseConnection {
	private $connection;

	public function connect() {
		$this->connection = new \mysqli('localhost', 'root', 'password');
		$this->connection->select_db('Login');
	}

	public function getAllRegisteredUsers() {
		$sql = "SELECT username FROM members";
		$result = $this->connection->query($sql);

		while($row = $result->fetch_array()) {
			$members[] = $row[0];
		}

		return $members;
	}

	public function correspondUsernamePassword($username, $password) {
		$sql = "SELECT password FROM members WHERE BINARY username='" . $username . "'";
		$result = $this->connection->query($sql);
		while($row = $result->fetch_array()) {
			if($password == $row[0]) {
				return true;
			}
		}
		return false;
	}

	public function setCookieIdToMember($username) {
		$sql = "UPDATE members SET cookie='" . $_COOKIE["CookiePassword"] . "' WHERE username='" . $username . "'";
		$this->connection->query($sql);
	}
}