<?php
/*********************** Login Page *******************/

// loading configuration, database connection and functions.
include_once('config.php');
include_once("connect.php");
include_once('user/functions.php');
session_start();






//redirect user if session is already set
if(isset($_SESSION['username']))
{
	if($_SESSION['role']=='ADM'){
		header('Location:admin/');
	}
	else if($_SESSION['role']=='USR'){
		header('Location:user/');
	}
}







//initializing fail login count
if (!isset($_SESSION['login_count'])) {
	$_SESSION['login_count']=0;
}






//login logic
if(isset($_POST["login"])) {
	$myusername = mysqli_escape_string($conn,$_POST['spec_id']);
	$mypassword = mysqli_escape_string($conn,$_POST['tambola_password']);
	$sql=$conn->prepare("SELECT * FROM user WHERE username =? and password =AES_ENCRYPT(?,?)");
	$sql->bind_param('sss',$myusername,$mypassword,$db_encryption_key);
	$sql->execute();
	$result=$sql->get_result(); 
	$row = $result->fetch_assoc();
	$count = $result->num_rows;
	if($count == 1) {
		$_SESSION['username'] = $myusername;
		$_SESSION['fname']=$row['fname'];
		$_SESSION['lname']=$row['lname'];
		$_SESSION['role']=$row['role'];
		$_SESSION['vertical']=$row['vertical'];
		$_SESSION['email']=$row['email'];
		if($_SESSION['role']=='ADM'){
			header('Location:admin/');
		}
		else if($_SESSION['role']=='USR'){
			header('Location:user/');
		}
	}
	else {
		$error = "Your Username or Password is invalid";
		$_SESSION['login_count']=$_SESSION['login_count']+1;
	}
}






//limit number of fail logins
if ($limit_login_attemps) {
	$can_retry_after_seconds = 60;
	if (isset($error)||$_SESSION['login_count']>=$block_after) {
		if($_SESSION['login_count']>$display_alert_after && $_SESSION['login_count']<$block_after){
			$remainingLogin=$block_after-$_SESSION['login_count'];
			$error.=", ".$remainingLogin." Chances Left.";
		}
		else if($_SESSION['login_count']>=$block_after){
			$error="You maximum login limit has been exceeded, Please try after some time";
		}

		if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $can_retry_after)) 
		{
			session_unset();     
			session_destroy();   
			unset($error);
		}
		if(!isset($_SESSION['timing'])){
			$_SESSION['testing'] = time();
		}
	}
}





//signup
if(isset($_POST["signup"])){
	$myusername=mysqli_escape_string($conn,$_POST['spec_id']);

	$sql=$conn->prepare("SELECT *,AES_DECRYPT(`password`,?) as pass_d FROM `user` WHERE username = ?");
	$sql->bind_param('ss',$myusername,$db_encryption_key);
	$sql->execute();
	$result=$sql->get_result();

	$row = $result->fetch_assoc();
	$count = $result->num_rows;

	if($count >= 1) {
		$success_message="Please Check Your Email For Credentials";
		registrationMail($row['email'],$row['fname'].' '.$row['lname'],$myusername,$row['pass_d']);
	}
	else
	{
		$error="No User Found For The Given Username";
	}
}


if(isset($_POST["signup_front"])){
	if ($email_as_username) {
		$myusername=mysqli_escape_string($conn,$_POST['email']);
	}
	else{
		$myusername=mysqli_escape_string($conn,$_POST['spec_id']);	
	}
	$fname=mysqli_escape_string($conn,$_POST['fname']);
	$lname=mysqli_escape_string($conn,$_POST['lname']);
	$email=mysqli_escape_string($conn,$_POST['email']);
	$password=randomPassword();
	$role='USR';
	$stmt=$conn->prepare("INSERT INTO `user`(`username`, `fname`, `lname`, `role`, `email`, `password`, `no_tickets`, `status`) VALUES (?,?,?,?,?,AES_ENCRYPT(?,?),0,'new')");
	$stmt->bind_param('sssssss',$myusername,$fname,$lname,$role,$email,$password,$db_encryption_key);
	if($stmt->execute()){
		$success_message="User Registration Successful";	
		registrationMail($email,$fname.' '.$lname,$myusername,$password);
	}
	else{
		$error="Something Went Wrong During Registration";	
	}
}
?>





<!-- output starts -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $application_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome-all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/swiper.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="css/product-sans.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="login">
	<div class="container-fluid">
		<div class="row login-row">
			<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
				<div id="svgContainer"></div>
			</div>
			<div class="col-12">
				<div class="py-2">
					<div class="row">
						<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-4 offset-lg-4 login-wrapper">
							<?php 
							if (isset($success_message)) {
								echo '<div class="alert text-center alert-success">'.$success_message.'</div>';
							} 
							
							if (isset($error)) {
								echo '<div class="alert text-center alert-danger">'.$error.'</div>';
							} 
							if (!isset($_SESSION['login_count'])||$_SESSION['login_count']<$block_after) {
								?>
								<ul class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#login">Login</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#signup">Sign Up</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane container pt-2 active" id="login">
										<form action = "" method = "post" autocomplete="off">
											<div class="form-group">
												<input type="text" class="form-control" name ="spec_id" placeholder="Username" autocomplete="off" required>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" name="tambola_password" autocomplete="off" placeholder="Password" required>
											</div>
											<input type = "submit" value = " Submit " class="btn btn-primary" name="login" /><br/>
										</form>
									</div>
									<div class="tab-pane container py-3" id="signup">
										<?php if($allow_frontend_signup){ ?>
											<form method="POST">
												<div class="row">
													<?php if (!$email_as_username) { ?>
														<div class="col-12 order-1">
															<div class="form-group">
																<input type="text" name="spec_id" class="form-control" placeholder="Username" required autocomplete="off">
															</div>
														</div>
													<?php } ?>
													<div class="col-12 col-md-6 order-2">
														<div class="form-group">
															<input type="text" name="fname" class="form-control" placeholder="First Name" required autocomplete="off">
														</div>
													</div>
													<div class="col-12 col-md-6 order-3">
														<div class="form-group">
															<input type="text" name="lname" class="form-control" placeholder="Last Name" required autocomplete="off">
														</div>
													</div>
													<div class="col-12 <?php if ($email_as_username) {echo 'order-1';}else{echo 'order-4';}?>">
														<div class="form-group">
															<input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="off">
														</div>
													</div>
													<div class="col-12 py-3 order-5">
														<input type="checkbox" name="tnc" required> I Accept the <a href="#" data-toggle="modal" data-target="#myModal">Terms and Conditions</a>
													</div>
												</div>
												<button type="submit" class="btn btn-primary" name="signup_front">Submit</button>
											</form>
										<?php } else {?>
											<form method="POST">
												<div class="row">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<input type="text" name="spec_id" class="form-control" placeholder="Username" required autocomplete="off">
														</div>
													</div>
													<div class="col-12 py-3">
														<input type="checkbox" name="tnc" required> I Accept the <a href="#" data-toggle="modal" data-target="#myModal">Terms and Conditions</a>
													</div>
												</div>
												<button type="submit" class="btn btn-primary" name="signup">Submit</button>
											</form>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-dark">Terms and Conditions</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body text-dark">
				<?php echo $terms_and_conditions; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/lottie.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>