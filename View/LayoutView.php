<?php

namespace View;

class LayoutView {
  public function renderLoginForm($isLoggedIn, LoginView $v, DateTimeView $dtv, $username = null) {
    echo '<!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <title>Login Example</title>
      </head>
      <body>
        <h1>Assignment 2</h1>
        <a href="?register">Register a new user</a>
        ' . $this->renderIsLoggedIn($isLoggedIn) . '
        <div class="container">
          ' . $v->response($isLoggedIn, $username) . '
          ' . $dtv->show() . '
        </div>
      </body>
    </html>
    ';
  }

  public function renderRegisterForm(RegisterView $v, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <title>Login Example</title>
      </head>
      <body>
        <h1>Assignment 2</h1>
        <a href="?">Back to login</a>
        ' . $this->renderIsLoggedIn(false) . '
        <div class="container">
          ' . $v->repsonse() . '
          ' . $dtv->show() . '
        </div>
      </body>
    </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
