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

	public static function loginByManipulatedCookies() {
		self::$message = 'Wrong information in cookies';
	}

	public static function registerWithoutAnyInformation() {
		self::$message = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
	}

	public static function registerWithEmptyPasswords() {
		self::$message = 'Password has too few characters, at least 6 characters.';
	}

	public static function registerWithAShortUsername() {
		self::$message = 'Username has too few characters, at least 3 characters.';
	}

	public static function registerWithAShortPassword() {
		self::$message = 'Password has too few characters, at least 6 characters.';
	}

	public static function registerWithADifferentPasswords() {
		self::$message = 'Passwords do not match.';
	}

	public static function registerWithAnExistingUser() {
		self::$message = 'User exists, pick another username.';
	}

	public static function registerWithNotAllowedCharacters() {
		self::$message = 'Username contains invalid characters.';
	}

	public static function registeredNewUser() {
		self::$message = 'Registered new user.';
	}
}