<?php

// #################################################### //

$accesslist   = ( isset($_GET['list']) ) ? $_GET['list'] : 'private';
$localcookie  = ( isset($_COOKIE['localauth']) ) ? $_COOKIE['localauth'] : false;

// #################################################### //

header('Content-Type: text/plain');

# Wenn Cookie vorhanden und valide, dann authorisiert
if ( validatejwt($localcookie, $accesslist) ) {
  http_response_code(204);
  exit;
}

# Kein Servicecookie vorhanden, aber Token in URL mitgegeben
if ( is_int(strpos($forwarduri, $delim) ) ) {
  $urlparam = $forwarduri;
  $reg_str = '#' . $delim . '(.*)' . $delim . '#';
  preg_match($reg_str, $urlparam, $urlhash);

  # Validiere Token in URL
  if (validatejwt($urlhash[1], $accesslist)) {
    $cleanurl = 'https://'.$forwardhost
      .preg_replace($reg_str, '', $forwarduri);
    setcookie('localauth', $urlhash[1], $globalexp, '/', $forwardhost);
    header('Location: '.$cleanurl);
    http_response_code(302);
    exit;
  } else {
    // header('Content-Type: text/plain');
    // var_dump( $forwardhost.$forwarduri );
    // var_dump( $cleanurl );
      // http_response_code(400);
      // exit;
  }
}

# Hier weder Servicecookie noch valider Token vorhanden
# Auf SSO Domain leiten
if ( $forwardhost != $aliasdomain ) {
  $cleanurl = 'https://'.$forwardhost
    .preg_replace($reg_str, '', $forwarduri);
  $appendlist = ($requireuser) ?  "&list=".$accesslist : "";
  header('Location: https://' . $aliasdomain . '/?service=' . urlencode($cleanurl) . $appendlist );
  http_response_code(302);
  exit;
}
