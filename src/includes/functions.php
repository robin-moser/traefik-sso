<?php

/**
 * generates a jwt (token) with given parameters
 * and encodes it with the current secret
 *
 * @param string $username  the name of the requesting user
 * @param int $exp  the absolute unix timestamp, when the token expires
 * @return JWT
 */
function getjwt( $username = null, $exp = null ) {

  $jwtdata = [
    'jti' => base64_encode(time()),
    'iat' => time(),
    'exp' => $exp,
    'user' => $username,
  ];

  return JWT::encode($jwtdata, Secret::get());

}

/**
 * validates a given jwt (token) against an accesslist
 *
 * @param string $jwttoken  the jwt to be checked
 * @param string accesslist  the name of the accesslist to validate against
 * @return bool
 */
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

/**
 * checks, if a user is member of a given list
 *
 * @param string $user  the user to check
 * @param string $list  the list to be checked against
 * @return bool
 */
function userinlist($user, $list) {
  global $credentials;

  $arrlist = $credentials['lists'];
  if (array_key_exists($list, $arrlist) && in_array($user, $arrlist[$list]['users'])) {
    return true;
  } else {
    return false;
  }
}
