<?php

// #################################################### //

$password     = ( isset($_POST['password']) ) ? $_POST['password'] : false;
$username     = ( isset($_POST['user']) && strlen($_POST['user']) ) ? $_POST['user'] : 'admin';

$service      = ( isset($_GET['service']) ) ? $_GET['service'] : false;
$accesslist   = ( isset($_GET['list']) ) ? $_GET['list'] : 'private';
$globalcookie = ( isset($_COOKIE['globalauth']) ) ? $_COOKIE['globalauth'] : false;

// #################################################### //

if ( $service && validatejwt($globalcookie, $accesslist ) ) {
  header("Location: ". $service . $delim . $globalcookie . $delim);
  http_response_code(302);
  exit;
}

# Formularweiterlietung auf Auth Seite mit Passwort als post
if ( array_key_exists($accesslist, $credentials['lists'])
     && in_array($username, $credentials['lists'][$accesslist]['users'])
     && password_verify($password, $credentials['users'][$username]) ) {

  setcookie('globalauth', getjwt($username,$globalexp), $globalexp);

  if (isset($_GET['service'])) {
    header("Location: ". $service . $delim . getjwt($username,$globalexp) . $delim);
    http_response_code(302);
    exit;

  } else {
    http_response_code(200);
  }

} elseif ($password == "logout") {
  Secret::change();
  $logout = true;
}

require_once("includes/view.php");
