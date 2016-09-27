<?php

namespace Controller;

// Require Model members
require_once('Model/User/Credentials.php');
require_once('Model/User/LogInSystem.php');
require_once('Model/User/RegisterSystem.php');

// Require View members
require_once('View/ResponseMessage.php');
require_once('View/LayoutView.php');
require_once('View/LoginView.php');
require_once('View/DateTimeView.php');
require_once('View/RegisterView.php');

use Model\User\Credentials as Credentials;
use Model\User\LogInSystem as LogInSystem;
use Model\User\RegisterSystem as RegisterSystem;

use View\ResponseMessage as ResponseMessage;
use View\LayoutView as LayoutView;
use View\LoginView as LoginView;
use View\DateTimeView as DateTimeView;
use View\RegisterView as RegisterView;

class MasterController {
	private $logInSystem;
	private $cookiesExists;
	private $registerSystem;
	
	private $layoutView;
	private $logInView;
	private $dateTimeView;
	private $registerView;

	private $username;
	private $password;

	private $userWantsToLogin;
	private $userWantsToLogout;
	private $keep;
	private $userWantsToRegister;
	private $userWantsToShowRegisterForm;

	public function __construct() {
		$this->logInSystem = new LogInSystem();
		$this->cookiesExists = isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword']);
		$this->registerSystem = new RegisterSystem();

		$this->layoutView = new LayoutView();
		$this->logInView = new LoginView();
		$this->dateTimeView = new DateTimeView();
		$this->registerView = new RegisterView();

		$this->username = $this->logInView->getRequestUserName();
		$this->password = $this->logInView->getRequestPassword();
	}

	public function run() {
		$this->userWantsToLogin = $this->logInView->getRequestLogin() !== null;
		$this->userWantsToLogout = $this->logInView->getRequestLogout() !== null && $this->logInSystem->isLoggedIn();
		$this->keep = $this->logInView->getRequestKeepMeLoggedIn() !== null;
		$this->userWantsToShowRegisterForm = isset($_GET['register']);
		$this->userWantsToRegister = $this->registerView->getRequestRegister();

		if($this->userWantsToRegister) {
			$this->register();
		}

		if($this->userWantsToShowRegisterForm) {
			$this->sendResponseToView();
			return;
		}

		if($this->userWantsToLogin || $this->cookiesExists) {
			$this->login();
		}

		if($this->userWantsToLogout) {
			$this->logInSystem->logout();
			ResponseMessage::logout();
		}

		// first time login
		elseif(!isset($_SESSION['isLoggedIn']) && $this->logInSystem->login()) {
			if($this->keep) {
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
			catch(\LoginByManipulatedCookiesException $e) {
				ResponseMessage::loginByManipulatedCookies();
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

	private function register() {
		$username = $this->registerView->getRequestUserName();
		$password = $this->registerView->getRequestPassword();
		$passwordRepeat = $this->registerView->getRequestPasswordRepeat();

		try {
			$this->registerSystem->validateCredentials($username, $password, $passwordRepeat);
		}
		catch(\RegisterWithoutAnyInformationException $e) {
			ResponseMessage::registerWithoutAnyInformation();
		}
		catch(\RegisterWithEmptyPasswordsException $e) {
			ResponseMessage::registerWithEmptyPasswords();
		}
		catch(\RegisterWithAShortUsernameException $e) {
			ResponseMessage::registerWithAShortUsername();
		}
		catch(\RegisterWithAShortPasswordException $e) {
			ResponseMessage::registerWithAShortPassword();
		}
		catch(\RegisterWithADifferentPasswordsException $e) {
			ResponseMessage::registerWithADifferentPasswords();
		}
	}

	private function sendResponseToView() {
		$dateTimeView = $this->dateTimeView;

		if($this->userWantsToShowRegisterForm) {
			$this->registerView->setResponseMessage(ResponseMessage::message());
			$registerView = $this->registerView;
			$this->layoutView->renderRegisterForm($registerView, $dateTimeView);
		}
		else {
			$this->logInView->setResponseMessage(ResponseMessage::message());
			$isLoggedIn = $this->logInSystem->isLoggedIn();
			$logInView = $this->logInView;

			$this->layoutView->renderLoginForm($isLoggedIn, $logInView, $dateTimeView);
		}
	}
}