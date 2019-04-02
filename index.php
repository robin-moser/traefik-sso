<?php

require_once('classes/jwt.class.php');
require_once('classes/secret.class.php');

http_response_code(401);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$t1 = microtime();

$userpass     = ( isset($_POST['password']) ) ? $_POST['password'] : false;
$service      = ( isset($_GET['service']) ) ? $_GET['service'] : false;

$forwardhost  = ( isset($_SERVER['HTTP_X_FORWARDED_HOST']) ) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : false;
$forwarduri   = ( isset($_SERVER['HTTP_X_FORWARDED_URI']) ) ? $_SERVER['HTTP_X_FORWARDED_URI'] : false;

$localcookie  = ( isset($_COOKIE['localauth']) ) ? $_COOKIE['localauth'] : false;
$globalcookie = ( isset($_COOKIE['globalauth']) ) ? $_COOKIE['globalauth'] : false;

$aliasdomain  = getenv('WEB_ALIAS_DOMAIN') ? getenv('WEB_ALIAS_DOMAIN') : exit;

$delim        = '/' . Secret::gettiny() . '/';
$pwhash       = getenv( 'PASSWORD' );
$exptime      = time() + ( 60 * 60 * 3 ); // 3 Stunden


# Wenn Cookie vorhanden und valide, dann authorisiert
if ( validatejwt($localcookie) ) {
  http_response_code(204);
  exit;
}

# Kein Servicecookie vorhanden, aber Token in URL mitgegeben
if ( strpos($forwarduri, $delim) ) {
  $urlparam = $forwarduri;
  $reg_str = '#' . $delim . '(.*)' . $delim . '#';
  preg_match($reg_str, $urlparam, $urlhash);

  # Validiere Token in URL
  if (validatejwt($urlhash[1])) {
    $cleanurl = 'https://'.$forwardhost
      .preg_replace($reg_str, '', $forwarduri);
    setcookie('localauth', getjwt(), $exptime, '/', $forwardhost);
    header('Location: '.$cleanurl);
    http_response_code(302);
    exit;
  }
}

# Hier weder Servicecookie noch valider Token vorhanden
# Falls Skript per Proxy auf Seite Domain läuft, auf SSO Domain leiten
if ( $forwardhost != $aliasdomain ) {
  http_response_code(302);
  header('Location: https://' . $aliasdomain . '/?service=' . urlencode($forwardhost.$forwarduri));
  exit;
}

if ( $service && validatejwt($globalcookie) ) {
  var_dump($_GET['service']);
  http_response_code(302);
  header("Location: https://". $service . $delim . getjwt() . $delim);
}

# Formularweiterlietung auf Auth Seite mit Passwort als post
if ( password_verify($userpass, $pwhash) ) {
  setcookie('globalauth', getjwt(), $exptime);
  if (isset($_GET['service'])) {
    http_response_code(302);
    header("Location: https://". $service . $delim . getjwt() . $delim);
    exit;
  } else {
    http_response_code(200);
  }
} elseif ($userpass == "logout") {
  Secret::change();
  $success = true;
}

function getjwt() {
  global $exptime;

  $jwtdata = [
    'jti' => base64_encode(time()),
    'iat' => time(),
    'exp' => $exptime,
  ];
  return JWT::encode($jwtdata, Secret::get());
}

function validatejwt($jwttoken) {
  try {
    $jwtdata = JWT::decode($jwttoken, Secret::get());
  } catch(Exception $e) {
    return false;
  }
  if (time() < $jwtdata->exp) {
    return true;
  } else {
    return false;
  }
}

include("view.php");

?>

