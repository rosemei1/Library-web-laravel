<?php
require_once 'src/Facebook/autoload.php'; 

$appId     = "571032017552909"; 
$appSecret = "07cffb831d4d23629967de3405da225d"; 

class db {

  function __construct() {
    $dbhost = "localhost"; 
    $dbuser = "root"; 
    $dbpass = ""; 
    $dbname = "library"; 
    $this->mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname );
    if(mysqli_connect_error()) {
      die("Tidak Bisa Konek Ke Database Karena : ". mysqli_connect_errno());
    }
  }

  function redirect($url) {
    echo "<script type='text/javascript'>window.top.location='$url';</script>";
  }
}
