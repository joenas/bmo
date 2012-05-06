<?php
// ===========================================================================================
//
// Origin: http://github.com/mosbth/Utility
//
// Filename: login.php
//
// Description: Provide a set of functions to enable login & logout on a website.
//
// Author: Mikael Roos, mos@bth.se
//
// Change history:
// 
// 2011-01-26: 
// First try. Used as example code in htmlphp-kmom03.
//

// Modified to Object by Jon Neverland

class Login {

  public function __construct($baseUrl = '/') {
    $this->baseUrl = $baseUrl;
  }

  // -------------------------------------------------------------------------------------------
  //
  // Is user authenticated and logged in?
  //
  public function userIsAuthenticated() {
    if(isset($_SESSION['authenticated'])) {
      return $_SESSION['authenticated'];
    } else {
      return false;
    }
  }


  // -------------------------------------------------------------------------------------------
  //
  // create the login/logout menu
  //
  public function userLoginMenu($baseUrl = '') {

    // array with all menu items
    $menu = array(
      "login"   => "$baseUrl/login",
      "status"   => "$baseUrl/login/status",
      "logout"   => "$baseUrl/login/logout",  
    );

    // check if user is logged in or not, alter the menu depending on the result
    if($this->userIsAuthenticated()) {
      unset($menu['login']);
    } else {
      unset($menu['status']);
      unset($menu['logout']); 
    }
    
    $html = "<nav class='login'>";
    foreach($menu as $key=>$val) {
      $html .= "<a href='$val'>$key</a> ";
    }
    $html .= "</nav>";
    return $html;
  }


  // -------------------------------------------------------------------------------------------
  //
  // Get login-form
  //
  public function userLoginForm($baseUrl, $output=null, $outputClass=null) {

    if(isset($output)) {
      $output = "<p><output class='$outputClass'>$output</output></p>";
    }

    $disabled = null;
    $disabledInfo = null;
    if($this->userisAuthenticated()) {
      $disabled = "disabled";
      $disabledInfo = "<em class='quiet small'>Du är inloggad, du måste <a href='".$baseUrl."admin/logout'>logga ut</a> innan du kan logga in.</em>";
    }

    $html = <<< EOD
    <form method="post" action="{$baseUrl}admin/login" class="login">
    <fieldset>
      <legend class="login">Admin</legend>
      $output
      <p>
        <label for="input1">Användarkonto:</label><br>
        <input id="input1" class="text" type="text" name="account">
      </p>
      <p>
        <label for="input2">Lösenord:</label><br>
        <input id="input2" class="text" type="password" name="password">
      </p>
      <p>
        <input type="submit" name="doLogin" value="Login" $disabled>
        $disabledInfo
      </p>
    </fieldset>
  </form>
EOD;

    return $html;
  }


  // -------------------------------------------------------------------------------------------
  //
  // Login the user
  //
  public function userLogin($baseUrl, $userAccount, $userPassword) {
  //  $userAccount = USER;
    //$userPassword = PASSWORD;
    
    // if form is submitted then try to login
    // $_POST['doLogin'] is related to the name of the login-button
    $output=null;
    $outputClass=null;
    if(isset($_POST['doLogin'])) {
    
      // does account and password match?
      if($userAccount == $_POST['account'] && $userPassword == $this->userPassword($_POST['password'])) {
  	    $_SESSION['authenticated'] = true;
        return true;
  	  //
      } 
      return false;
    }
    
    return $this->userLoginForm($baseUrl, $output, $outputClass);
  }


  // -------------------------------------------------------------------------------------------
  //
  // Logout the user
  //
  public function userLogout() {
    unset($_SESSION['authenticated']);
  }


  // -------------------------------------------------------------------------------------------
  //
  // Generate a password
  //
  function userPassword($password) {
    return sha1($password);
  }

}