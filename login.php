<?php 

require_once("config.php");


if(isset($_POST['login'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$password = md5($_POST["password"]);

	

    $sql = "SELECT * FROM users WHERE email=:email";

    $stmt = $db->prepare($sql);

    
    // bind parameter ke query
    $params = array(
        ":email" => $email
    );

    $stmt->execute($params);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // jika user terdaftar
    if($user){
        // verifikasi password{
			if($user['role'] == 0){
				session_start();
				$_SESSION["user"] = $user;
				header("Location: main.php");
			}else{

				session_start();
				$_SESSION["user"];
				// login sukses, alihkan ke halaman timeline
				header("Location: admin.php");
			}
    }
}
?>



<!doctype html>
<html lang="en">
  <head>
  	<title>Sign In - MOCO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="assets/logo.png" />
	<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="css/style_SignIn.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(assets/img/bg-masthead.jpg);">
	<section class="ftco-section ">
		<div class="container ">
			<div class="login">
				
				<div class="back" style="margin-left: 7%;">
					<a href="index.php" style="color: #f48120; font-size:30px;" ><i class="bi bi-house-door-fill"></i></a>    
				</div>

			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 mb-5" style="margin-left: 11.5%;">
					<!-- <h2 class="heading-section">Login #10</h2> -->
                    <img src="assets/logo.png" alt="" width="17%">
					
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Sign In</h3>
		      	<form action="#" class="signin-form" method="POST">
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Email" required name="email">
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Password" required name="password">
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn submit px-3" style="background-color: #f48120;" name="login">Sign In</button>
	            </div>
	          </form>
              <div class="d-flex justify-content-center links">
					Don't have an account? <a href="register.php" style="color: #f48120;">&nbsp; Sign Up</a>
				</div>
	          <p class="w-100 text-center" style="margin-top: 5%;">&mdash; Or Sign In With &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="loginfb.php" class="px-2 py-2 mr-md-1 rounded " ><span class="bi bi-facebook mr-2"></span> Facebook</a>
	          </div>
              
		      </div>
				</div>
			</div>
		</div>
	</section>
	
	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap1.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

