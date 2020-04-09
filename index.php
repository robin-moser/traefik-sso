<?php

require_once('includes/class.jwt.php');
require_once('includes/class.secret.php');

require_once('includes/class.secret.php');
require_once('includes/class.secret.php');

require_once('includes/functions.php');

http_response_code(401);

$credentials  = yaml_parse(file_get_contents('credentials.yml'));
$requireuser  = ( isset($_GET['list']) ) ? true : false;

$aliasdomain  = getenv('WEB_ALIAS_DOMAIN') ? getenv('WEB_ALIAS_DOMAIN') : die('No SSO Domain configured');

$forwardhost  = ( isset($_SERVER['HTTP_X_FORWARDED_HOST']) ) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : false;
$forwarduri   = ( isset($_SERVER['HTTP_X_FORWARDED_URI']) ) ? $_SERVER['HTTP_X_FORWARDED_URI'] : false;

$delim        = '/'.substr(md5(Secret::gettiny()),0,8).'/';
$globalexp    = strtotime($credentials['expire']);

# user is on service site, check local cookies
if ( $forwardhost != $aliasdomain ) {
  require_once('includes/logic.proxy.php');
} else {
  require_once('includes/logic.sso.php');
}

?>
