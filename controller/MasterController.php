<?php

namespace Controller;

// Require Model members
require_once('Model/User/Credentials.php');
require_once('Model/User/LogInSystem.php');

// Require View members
require_once('View/ResponseMessage.php');
require_once('View/LayoutView.php');
require_once('View/LoginView.php');
require_once('View/DateTimeView.php');
require_once('View/RegisterView.php');

use Model\User\Credentials as Credentials;
use Model\User\LogInSystem as LogInSystem;
use Model\User\Register as Register;

use View\ResponseMessage as ResponseMessage;
use View\LayoutView as LayoutView;
use View\LoginView as LoginView;
use View\DateTimeView as DateTimeView;
use View\RegisterView as RegisterView;

class MasterController {
	private $logInSystem;
	private $cookiesExists;
	
	private $layoutView;
	private $logInView;
	private $dateTimeView;
	private $registerView;

	private $username;
	private $password;

	public function __construct() {
		$this->logInSystem = new LogInSystem();
		$this->cookiesExists = isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']);
		
		$this->layoutView = new LayoutView();
		$this->logInView = new LoginView();
		$this->dateTimeView = new DateTimeView();
		$this->registerView = new RegisterView();

		$this->username = $this->logInView->getRequestUserName();
		$this->password = $this->logInView->getRequestPassword();
	}

	public function run() {
		$userWantsToLogin = $this->logInView->getRequestLogin() !== null;
		$userWantsToLogout = $this->logInView->getRequestLogout() !== null && $this->logInSystem->isLoggedIn();
		$keep = $this->logInView->getRequestKeepMeLoggedIn() !== null;

		if($userWantsToLogin || $this->cookiesExists) {
			$this->login();
		}

		if($userWantsToLogout) {
			$this->logInSystem->logout();
			ResponseMessage::logout();
		}

		// first time login
		elseif(!isset($_SESSION['isLoggedIn']) && $this->logInSystem->login()) {
			if($keep) {
				$this->logInSystem->keepLogIn($this->username);
				ResponseMessage::keep();
			}
			else {
				ResponseMessage::login();
			}
		}

		$this->sendResponseToView();
	}

	private function login() {
		$credentials = new Credentials($this->username, $this->password);

		if($this->cookiesExists) {
			try {
				if(!isset($_SESSION['isLoggedIn']) && $this->logInSystem->cookieLogin($_COOKIE['LoginView::CookieName'])) {
					ResponseMessage::welcomeBackWithCookie();
				}
			}
			catch(\LoginByManipulatedCookies $e) {
				ResponseMessage::LoginByManipulatedCookies();
			}
		}
		else { // cookies does not exists
			try {
				$this->logInSystem->validateCredentials($credentials);
			}
			catch(\LoginWithoutAnyEnteredFieldsException $e) {
				ResponseMessage::usernameIsMissing();
			}
			catch(\LoginWithOnlyUsernameException $e) {
				ResponseMessage::passwordIsMissing();
			}
			catch(\LoginWithOnlyPasswordException $e) {
				ResponseMessage::usernameIsMissing();
			}
			catch(\WrongNameOrPasswordException $e) {
				ResponseMessage::wrongNameOrPassword();
			}
		}
	}

	private function sendResponseToView() {
		$message = ResponseMessage::message();
		$isLoggedIn = $this->logInSystem->isLoggedIn();
		$logInView = $this->logInView;
		$dateTimeView = $this->dateTimeView;

		$this->logInView->setResponseMessage($message);
		$this->layoutView->render($isLoggedIn, $logInView, $dateTimeView);
	}
}