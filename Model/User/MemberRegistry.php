<?php

namespace Model\User;

require_once('Model/MySQLConnection.php');

use \Model\MySQLConnection as MySQLConnection;

class MemberRegistry {
	private $connection;

	public function __construct() {
		$connection = new MySQLConnection();
		$this->connection = $connection->connect();
	}

	public function usernameExists($username) {
		return in_array($username, $this->getAllUsernames());
	}

	public function usernamePasswordMatch(Credentials $credentials) {
		$username = $credentials->getUsername();
		$password = $credentials->getPassword();

		$sql = "SELECT `password` FROM `members` WHERE BINARY `username`='$username'";
		$result = $this->connection->query($sql);
		
		while($row = $result->fetch_array()) {
			if($password == $row[0]) {
				return true;
			}
		}
		return false;
	}

	public function updateCookie($username, $cookieValue) {
		$query = "UPDATE `members` SET `cookie` = '$cookieValue' WHERE `members`.`username` = '$username'";
		$this->connection->query($query);
	}

	public function usernameCookieMatch($cookieName, $cookiePassword) {
		$sql = "SELECT `cookie` FROM `members` WHERE BINARY `username`='$cookieName'";
		$result = $this->connection->query($sql);
		$password = $result->fetch_array();

		if($password[0] === $cookiePassword) {
			return true;
		}
		return false;
	}

	public function registerUser(Credentials $credentials) {
		$username = $credentials->getUsername();
		$password = $credentials->getPassword();
		
		$sql = "INSERT INTO `members` (`id`, `username`, `password`, `cookie`) VALUES (NULL, '$username', '$password', NULL);";
		$this->connection->query($sql);
	}

	private function getAllUsernames() {
		$getAllMembersQuery = 'SELECT username FROM members';
		$result = mysqli_query($this->connection, $getAllMembersQuery);
		
		while($row = $result->fetch_array()) {
			$members[] = $row[0];
		}

		return $members;
	}
}