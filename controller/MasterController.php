<?php

namespace controller;

require_once('view/View.php');
require_once('model/Model.php');

class MasterController {
    public function init() {
    	$login = new \model\Login();
		$dateTime = new\model\DateTime();

		$layoutView = new \view\LayoutView();
    	$loginView = new \view\LoginView();
    	$dateTimeView = new \view\DateTimeView($dateTime->getdate());
    	$layoutview = new \view\LayoutView();

    	$layoutView->render($login->isLoggedIn(), $loginView, $dateTimeView);
    }
}