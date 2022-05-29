
<?php
session_start();
require_once 'configfb.php';
$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.5',
]);

$helper = $fb->getRedirectLoginHelper();
$loginUrl = $helper->getLoginUrl("http://localhost/project-akhir/proses.php",array('scope' => 'email'));
header("location: " . $loginUrl);