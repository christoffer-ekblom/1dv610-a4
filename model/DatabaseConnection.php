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
}