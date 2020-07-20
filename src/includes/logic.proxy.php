<?php

# define the accesslist to check against
# the list should be defined in the traefik forward url
$accesslist   = ( isset($_GET['list']) ) ? $_GET['list'] : 'private';

# the cookie set on the service site
$localcookie  = ( isset($_COOKIE['localauth']) ) ? $_COOKIE['localauth'] : false;

# the clean url of the service site
$delim_regex = '#' . $delim . '(.*)' . $delim . '#';
$cleanurl = 'https://' . $forwardhost . preg_replace($delim_regex, '', $forwarduri);

header('Content-Type: text/plain');

# if a valid local cookie exists, then the user is authorized
if ( validatejwt($localcookie, $accesslist) ) {

  http_response_code(204);
  exit;

}

# the user got redirected to the service site after successfully authoirizing
# against the sso service, so he has valid hash in the url
if ( is_int(strpos($forwarduri, $delim) ) ) {

  $urlparam = $forwarduri;
  preg_match($delim_regex, $urlparam, $urlhash);

  # check if the jwt in the url is valid for the requiered accesslist
  if (validatejwt($urlhash[1], $accesslist)) {

    # jwt ist valid, so redirect to the clean service site and set the auth cookie
    setcookie('localauth', $urlhash[1], $globalexp, '/', $forwardhost);

    header('Location: '.$cleanurl);
    http_response_code(302);
    exit;

  }

}

# no valid cookie or jwt in the url existant,
# so redirect to the sso service to (re)authentificate
$appendlist = ($requireuser) ?  "&list=".$accesslist : "";
header('Location: https://' . $aliasdomain . '/?service=' . urlencode($cleanurl) . $appendlist );

http_response_code(302);
exit;
