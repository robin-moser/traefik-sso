<?php

/*
 * Robin Moser, 2020
 *
 * an authentication service written in PHP for the Traefik loadbalancer
 *
 */

# include required classes
require_once('includes/class.jwt.php');
require_once('includes/class.secret.php');
require_once('includes/class.events.php');

# include custom functions
require_once('includes/functions.php');

# include event binders
foreach (glob("includes/events/*.php") as $filename) {
    include $filename;
}

http_response_code(401);

require_once( 'config/credentials.php' );
$requireuser  = ( isset($_GET['list']) ) ? true : false;

# the service requires a domain, where it can redirect to, if needed
# the domain gets set with the environment variable WEB_ALIAS_DOMAIN
$aliasdomain  = getenv('NGINX_DOMAIN') ? getenv('NGINX_DOMAIN') : die('No SSO Domain configured');

$forwardhost  = ( isset($_SERVER['HTTP_X_FORWARDED_HOST']) ) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : false;
$forwarduri   = ( isset($_SERVER['HTTP_X_FORWARDED_URI']) ) ? $_SERVER['HTTP_X_FORWARDED_URI'] : false;

$delim        = '/'.substr(md5(Secret::gettiny()),0,8).'/';
$globalexp    = strtotime($credentials['expire']);

if ( $forwardhost != $aliasdomain ) {

  # the user is on the site of a traefik service, the request got proxied to the sso service
  # now we check, if the user is authentificated for that service
  require_once('includes/logic.proxy.php');

} else {

  # the user is on the sso service, so he either got redirected to enter his password
  # or he accessed the sso service directly
  require_once('includes/logic.sso.php');

}

?>
