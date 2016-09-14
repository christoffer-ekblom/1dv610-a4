<?php

namespace model;

class DatabaseConnection {
	private $connection;

	public function connect() {
		$this->connection = mysql_connect('localhost', 'root', 'password');
		$db = mysql_select_db('Login', $this->connection);
	}

	public function getAllRegisteredUsers() {
		$result = mysql_query("SELECT username FROM members");

		while($row = mysql_fetch_array($result)) {
			$members[] = $row[0];
		}

		return $members;
	}

	public function correspondUsernamePassword($username, $password) {
		$result = mysql_query("SELECT password FROM members WHERE username LIKE '$username'");

		while($row = mysql_fetch_array($result)) {
			if($password == $row[0]) {
				return true;
			}
		}
		return false;
	}
}