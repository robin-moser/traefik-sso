<?php

function getjwt( $username = null, $exp = null ) {

  $jwtdata = [
    'jti' => base64_encode(time()),
    'iat' => time(),
    'exp' => $exp,
    'user' => $username,
  ];

  return JWT::encode($jwtdata, Secret::get());

}

function validatejwt($jwttoken, $accesslist) {

  try {
    $jwtdata = JWT::decode($jwttoken, Secret::get());
  } catch(Exception $e) {
    return false;
  }

  if (time() < $jwtdata->exp) {
    if ($accesslist) {
      return userinlist($jwtdata->user, $accesslist);
    }
    return true;
  } else {
    return false;
  }
}

function userinlist($user, $list) {
  global $credentials;

  $arrlist = $credentials['lists'];
  if (array_key_exists($list, $arrlist) && in_array($user, $arrlist[$list]['users'])) {
    return true;
  } else {
    return false;
  }
}
