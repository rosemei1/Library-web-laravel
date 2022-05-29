<?php

use Facebook\Facebook;

session_start();
require_once 'configfb.php';

$fb = new Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.5',
]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch (Facebook\Exception\FacebookResponseException $e) {
  echo "Graph SDK Error : " . $e->getMessage();
  exit;
}

if(!isset($accessToken)) {
  if($helper->getError()) {
    header("HTTP/1.0 401 Unauthorized");
    echo "Error -> " .$helper->getError(). "\n";
    echo "Error Code -> " .$helper->getErrorCode(). "\n";
    echo "Error Reason -> " . $helper->getErrorReason(). "\n";
    echo "Error Description -> ". $helper->getErrorDescription(). "\n";
  }
  exit;
}

$OAuth         = $fb->getOAuth2Client();
$tokenMetadata = $OAuth->debugToken($accessToken);
$tokenMetadata->validateAppId($appId);
$tokenMetadata->validateExpiration();
if(!$accessToken->isLongLived()) {
  try {
    $accessToken = $OAuth->getLongLivedAccessToken($accessToken);
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo "Facebook SDK Error gan -> " . $e->getMessage();
      exit;
  }
}

$_SESSION['facebook_session'] = (string)$accessToken;
header("Location: password.php");