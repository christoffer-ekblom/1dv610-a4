<?php

namespace view;

class LayoutView {
  private $isLoggedIn;
  private $message;
  private $loginView;
  private $dateTimeView;

  public function render($isLoggedIn, $message, LoginView $v, DateTimeView $dtv, RegisterView $rv) {
    $this->isLoggedIn = $isLoggedIn;
    $this->message = $message;
    $this->loginView = $v;
    $this->dateTimeView = $dtv;

    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>';

    if(isset($_GET['register'])) {
      echo $rv->generateRegisterForm();
    }
    else {
      echo '<a href="?register">Register a new user</a>
          ' . $this->renderIsLoggedIn($this->isLoggedIn);
    }

    echo '<div class="container">';

    if(!isset($_GET['register'])) {
      echo $this->loginView->response($this->message);
    }

    echo $this->dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
