<?php
session_start();
require_once 'configfb.php';
include('config.php');
$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.5',
]);
if(empty($_SESSION['facebook_session'])) {
    echo "
  
    <html>
    <head>
    <title>Belajar Login With Facebook</title>
    <link rel='stylesheet' href='css/style_SignIn.css'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
     <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body class='img js-fullheight' style='background-image: url(assets/img/bg-masthead.jpg);'>
    <style>
  
          .panel-default {
          opacity: 0.9;
          margin-top:30px;
          }
          .form-group.last { margin-bottom:0px; }
    </style>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <div class='panel panel-default'>
            <div class='panel-heading'>
            </div>
            <div class='panel-body' style='word-wrap: break-word;'>
             <div class='col-md-12'>
               <h1 style='text-align:center;'>Kelihatanya anda belum login, Silahkan login terlebih dahulu dengan klik tombol dibawah ini.</h1><br /><br />
               <a href='login_fb.php'><img src='uploads/fblogin-btn.png' style='margin-left:35%;'></img></a>
           </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>
    
    ";
  } else {
    $token    = $_SESSION['facebook_session'];
    $data     = $fb->get("/me?fields=id,name,email,picture,link,gender",$token);
    $user     = $data->getGraphUser();
    $input    = new db();
    $nama     = $user['name'];
    $email    = $user['email'];
    if($cek = $input->mysqli->query("SELECT * FROM users WHERE token = '$token' ")) {
      if($cek->num_rows < 1 ) {
        $sql_user = $input->mysqli->query("INSERT INTO users (token) VALUES('$token')");
        if($sql_user) {
          $input->redirect("http://localhost/project-akhir/password.php");
        }
      }
    }
  }
  $cek_pass = "SELECT * FROM users WHERE token = '$token' ";
  if($cek_pass = $input->mysqli->query($cek_pass)) {
    if($cek_pass->num_rows > 0 ) {
      if($data = mysqli_fetch_array($cek_pass)) {
        if($data['password'] == '') {
          $pesan = "
          <div class='col-md-8' style='margin-left: 200px;'>
          <div class='panel panel-default' >
           <div class='panel-body'>
            <div class='col-md-12'>
            <form method='post'>
            <div class='form-group'>
            <input type='text' class='form-control' placeholder='First Name' required name='f_name'>
          </div>
          <div class='form-group'>
            <input type='text' class='form-control' placeholder='Last Name' required name='l_name'>
          </div>
            <div class='form-gr oup'>
             <label for='password'>Password </label>
             <input type='password' class='form-control' placeholder='Password' name='password'>
            </div>
            <div class='form-group'>
             <label for='cpassword'>Confirm Password</label>
             <input type='password' class='form-control' name='cpassword' placeholder='Confirm Password'>
            </div>
            </div>
             <button class='form-control btn submit px-3' style='background-color: #f48120; color:white;' type='submit' name='btn-save-password'>SAVE!</button>
           </form>
          </div>
         </div>
        </div>";
        }
      }
    }
  }
?>

<!DOCTYPE html>
  <html>
  <head>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' integrity='sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1' crossorigin='anonymous'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
   <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
  <div class='container'>
    <div class='row'>
      <?php
      require_once 'configfb.php';
      $db_host = "localhost";
      $db_user = "root";
      $db_pass = "";
      $db_name = "library";
      $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
      if(isset($_POST['btn-save-password'])) {
        $password  = md5($_POST['password']);
        $cpassword = md5($_POST['cpassword']);
        if($password != $cpassword) {
          echo "

          <br />
          <div class='alert alert-danger'>
           Password Konfirmasi Harus Sama!
          </div>

          ";
        } else {
          if($input->mysqli->query("UPDATE users SET password = '$cpassword' WHERE token = '$token'")) {
            echo "
            <br />
            <div class='alert alert-success'>
             Password Sukses Disimpan :)
            </div>
            ";
            

            $token    = $_SESSION['facebook_session'];
            $data     = $fb->get("/me?fields=id,name,email,picture,link,gender",$token);
            $email    = $user['email'];
            $nama_depan = $_POST['f_name'];
            $nama_belakang = $_POST['l_name'];
            $result_user = "INSERT INTO users (f_name,l_name,email,password,token) VALUES(:f_name, :l_name, :email, :password, :token)";
            $stmt = $db->prepare($result_user);
            $params = array(
              ":f_name" => $nama_depan,
              ":l_name" => $nama_belakang,
              ":password" => $password,
              ":email" => $email,
              ":token" => $token
          );
          $saved = $stmt->execute($params);


         if($saved){
            // jika berhasil
            $_SESSION['pesan_registrasi'] = "Registrasi Berhasil, Login Menggunakan Email dan Password anda!";

            header('location:login.php');

        } else {
            // jika query pendaftar gagal
            echo "Error insert pendaftar ". mysqli_error($koneksi);
            echo "<br><br> <button type='button' onclick='history.back();'> Kembali </button>";
            die;
        }
          }
        }
      }

      if(isset($pesan)) {
        echo $pesan;
      }

      ?>
      </div>
    </div>
  </body>
  </html>