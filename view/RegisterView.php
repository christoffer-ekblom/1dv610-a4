<?php

namespace view;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $message = 'RegisterView::Message';
	private static $username = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';

	public function response() {
		$un = filter_input(INPUT_POST, self::$username);
		$pw = filter_input(INPUT_POST, self::$password);
		$pwr = filter_input(INPUT_POST, self::$passwordRepeat);
		$btn = filter_input(INPUT_POST, self::$register);

		if($btn == "Register" && $un == null && $pw == null && $pwr == null) {
			$message = "Username has too few characters, at least 3 characters.<br>Password has too few characters, at least 6 characters.<br>User exists, pick another username.";
		}

		echo $this->generateRegisterForm($message);
	}

	public function generateRegisterForm($message) {
  		return "<a href='?'>Back to login</a><h2>Not logged in</h2>
  			<h2>Register new user</h2>
  			<form action='?register' method='post' enctype='multipart/form-data'>
				<fieldset>
				<legend>Register a new user - Write username and password</legend>
					<p id='" . self::$message . "'>" . $message . "</p>
					<label for='" . self::$username . "' >Username :</label>
					<input type='text' size='20' name='" . self::$username . "' id='" . self::$username . "' value='' />
					<br/>
					<label for='" . self::$password . "' >Password  :</label>
					<input type='password' size='20' name='" . self::$password . "' id='" . self::$password . "' value='' />
					<br/>
					<label for='" . self::$passwordRepeat . "' >Repeat password  :</label>
					<input type='password' size='20' name='" . self::$passwordRepeat . "' id='" . self::$passwordRepeat . "' value='' />
					<br/>
					<input id='submit' type='submit' name='" . self::$register . "' value='Register' />
					<br/>
				</fieldset>
			</form>";
  }
}