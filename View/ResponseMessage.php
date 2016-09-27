<?php

namespace View;

class ResponseMessage {
	private static $message;
	
	private function __construct() {
		// empty
	}

	public static function message() {
		return self::$message;
	}

	public static function usernameIsMissing() {
		self::$message = 'Username is missing';
	}

	public static function passwordIsMissing() {
		self::$message = 'Password is missing';
	}

	public static function wrongNameOrPassword() {
		self::$message = 'Wrong name or password';
	}

	public static function login() {
		self::$message = 'Welcome';
	}

	public static function logout() {
		self::$message = 'Bye bye!';
	}

	public static function keep() {
		self::$message = 'Welcome and you will be remembered';
	}

	public static function welcomeBackWithCookie() {
		self::$message = 'Welcome back with cookie';
	}

	public static function LoginByManipulatedCookies() {
		self::$message = 'Wrong information in cookies';
	}
}