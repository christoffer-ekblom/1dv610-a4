<?php

namespace View;

class LoginView {

	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $message;

	public function response($isLoggedIn, $username = null) {
		if(!$isLoggedIn) {
			$response = $this->generateLoginFormHTML($username);
		}
		else {
			$response = $this->generateLogoutButtonHTML($this->message);
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML($username = null) {
		if($username == null) {
			$username = filter_input(INPUT_POST, self::$name);
		}
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $username . '" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function getRequestLogin() {
		return filter_input(INPUT_POST, self::$login);
	}

	public function getRequestLogout() {
		return filter_input(INPUT_POST, self::$logout);
	}

	public function getRequestUserName() {
		return filter_input(INPUT_POST, self::$name);
	}

	public function getRequestPassword() {
		return filter_input(INPUT_POST, self::$password);
	}

	public function getRequestCookieName() {
		return filter_input(INPUT_COOKIE, self::$cookieName);
	}

	public function getRequestCookiePassword() {
		return filter_input(INPUT_COOKIE, self::$cookiePassword);
	}

	public function getRequestKeepMeLoggedIn() {
		return filter_input(INPUT_POST, self::$keep);
	}
	
	public function setResponseMessage($message) {
		$this->message = $message;
	}
}
