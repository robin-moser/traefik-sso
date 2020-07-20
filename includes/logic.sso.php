<?php

# define userand password with the given parameters
$password     = ( isset($_POST['password']) ) ? $_POST['password'] : false;
$username     = ( isset($_POST['user']) && strlen($_POST['user']) ) ? $_POST['user'] : 'admin';

# define the service with the accesslist the user wants to access
$service      = ( isset($_GET['service']) ) ? $_GET['service'] : false;
$accesslist   = ( isset($_GET['list']) ) ? $_GET['list'] : 'private';

# the sso cookie set on the sso service
$globalcookie = ( isset($_COOKIE['globalauth']) ) ? $_COOKIE['globalauth'] : false;


# if a sso cookie exists and is valid against the required accesslist,
# then user is authentificated, so redirect to the service with a hash for the local cookie
if ( $service && validatejwt($globalcookie, $accesslist ) ) {

  header("Location: ". $service . $delim . $globalcookie . $delim);
  http_response_code(302);
  exit;

}

# the user is not authentificated, so check, if a password was posted
if ( array_key_exists($accesslist, $credentials['lists'])
     && in_array($username, $credentials['lists'][$accesslist]['users'])
     && password_verify($password, $credentials['users'][$username]) ) {

  # the user posted a valid password, so we can set the global sso cookie for this user
  setcookie('globalauth', getjwt($username,$globalexp), $globalexp);

  # if the user was redirected to the sso service and a service url was given as a parameter,
  # redirect back to the first requested service
  if (isset($_GET['service'])) {

    header("Location: ". $service . $delim . getjwt($username,$globalexp) . $delim);
    http_response_code(302);
    exit;

  } else {

    http_response_code(200);

  }

  # if the user posted the string logout as a password,
  # change the jwt to log every user out
} elseif ($password == "logout") {

  Secret::change();
  $logout = true;

}

# no valid authentification and no (or invalid) password given,
# so display the login view
require_once("includes/view.php");
