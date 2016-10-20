<?php

namespace View;

class RegisterView {
	private static $username = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $register = 'RegisterView::Register';
	private static $messageId = 'RegisterView::Message';
	private $message;

	public function repsonse() {
		$response = $this->generateRegisterFormHTML();
		return $response;
	}

	private function generateRegisterFormHTML() {
		return "<form action='?register' method='post' enctype='multipart/form-data'>
				<fieldset>
				<legend>Register a new user - Write username and password</legend>
					<p id='" . self::$messageId . "'>" . $this->message . "</p>
					<label for='" . self::$username . "' >Username :</label>
					<input type='text' size='20' name='" . self::$username . "' id='" . self::$username . "' value='" . strip_tags(filter_input(INPUT_POST, self::$username)) . "' />
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

	public function getRequestUserName() {
		return filter_input(INPUT_POST, self::$username);
	}

	public function getRequestPassword() {
		return filter_input(INPUT_POST, self::$password);
	}

	public function getRequestPasswordRepeat() {
		return filter_input(INPUT_POST, self::$passwordRepeat);
	}

	public function getRequestRegister() {
		return filter_input(INPUT_POST, self::$register);
	}

	public function setResponseMessage($message) {
		$this->message = $message;
	}
}
