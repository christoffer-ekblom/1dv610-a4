<?php

namespace Model;

require_once('mysqlCredentials.php');

class MySQLConnection {
	private $host;
	private $username;
	private $password;
	private $db;
	private $connection;

	public function __construct() {
		$mysqlCredentials = getCredentials();
		$this->host = $mysqlCredentials['host'];
		$this->username = $mysqlCredentials['username'];
		$this->password = $mysqlCredentials['password'];
		$this->db = $mysqlCredentials['db'];
	}

	public function connect() {
		$this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
		return $this->connection;
	}
}