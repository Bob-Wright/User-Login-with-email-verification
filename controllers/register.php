<?php
// Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php');

// Error & success messages
$_SESSION['email_exist'] = ''; $_SESSION['f_NameErr'] = ''; $_SESSION['l_NameErr'] = ''; $_SESSION['_emailErr'] = ''; $_SESSION['_mobileErr'] = '';$_SESSION['$_passwordErr'] = '';
$_SESSION['fNameEmptyErr'] = ''; $_SESSION['lNameEmptyErr'] = ''; $_SESSION['emailEmptyErr'] = ''; $_SESSION['mobileEmptyErr'] = ''; $_SESSION['$passwordEmptyErr'] = '';
$_SESSION['email_verify_success'] = '';
// Set empty form vars for validation mapping
$_first_name = $_last_name = $post_email = $_mobile_number = $_password = "";
$firstname = $lastname = $_email = $mobilenumber = $password = "";

if(isset($_POST["submit"])) {
	$firstname     = $_POST["firstname"];
	$lastname      = $_POST["lastname"];
	$post_email	   = $_POST["email"];
	$mobilenumber  = $_POST["mobilenumber"];
	$password  = $_POST["password"];
// Verify form values not empty
if(empty($firstname) || empty($lastname) || empty($post_email) || empty($mobilenumber) || empty($password)){
	if(empty($firstname)){
		$_SESSION['fNameEmptyErr'] = '<div class="alert alert-danger">
			First name cannot be blank.
		</div>';
	}
	if(empty($lastname)){
		$_SESSION['lNameEmptyErr'] = '<div class="alert alert-danger">
			Last name cannot be blank.
		</div>';
	}
	if(empty($post_email)){
		$_SESSION['emailEmptyErr'] = '<div class="alert alert-danger">
			Email cannot be blank.
		</div>';
	}
	if(empty($mobilenumber)){
		$_SESSION['mobileEmptyErr'] = '<div class="alert alert-danger">
			Mobile number cannot be blank.
		</div>';
	}
	if(empty($password)){
		$_SESSION['passwordEmptyErr'] = '<div class="alert alert-danger">
			Password cannot be blank.
		</div>';
	}
	//echo 'a value is empty<br>';
}	
$_SESSION['formdata'] = '<br>form data is present<br>';
}
	// clean the form data
	$_first_name = mysqli_real_escape_string($connection, $firstname);
	$_last_name = mysqli_real_escape_string($connection, $lastname);
	$_email = mysqli_real_escape_string($connection, $post_email);
	$_mobile_number = mysqli_real_escape_string($connection, $mobilenumber);
	$_password = mysqli_real_escape_string($connection, $password);

	// perform validation
	if(!preg_match("/^[a-zA-Z][a-zA-Z\s]*$/", $_first_name)) {
		$_SESSION['f_NameErr'] = '<div class="alert alert-danger">
				Only letters and white space allowed.
			</div>';
	}
	if(!preg_match("/^[a-zA-Z][a-zA-Z\s]*$/", $_last_name)) {
		$_SESSION['l_NameErr'] = '<div class="alert alert-danger">
				Only letters and white space allowed.
			</div>';
	}
	$_emailErr = "";
	$_email = filter_var($_email, FILTER_SANITIZE_EMAIL);
	if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['_emailErr'] = '<div class="alert alert-danger">
				Email format is invalid.
			</div>';
	}
	if(!preg_match("/^[0-9]{10}+$/", $_mobile_number)) {
		$_SESSION['_mobileErr'] = '<div class="alert alert-danger">
				Only 10-digit mobile numbers allowed.
			</div>';
	}
	if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#!%&])[A-Za-z0-9@#!%&]{6,20}$/", $_password)) {
		$_SESSION['_passwordErr'] = '<div class="alert alert-danger">
				 Password should be between 6 to 20 characters long, both lowercase and uppercase, and contain at least one special character (@#!%&) and a digit.
			</div>';
			$pwdtest = false;
	} else {
		$pwdtest = true;
	}
	
	// Store the data in db, if all the preg_match condition met
if(($_SESSION['f_NameErr'] == '') && ($_SESSION['l_NameErr'] == '') && ($_SESSION['_emailErr'] == '') && ($_SESSION['_mobileErr'] == '') && ($pwdtest == true)){
$_SESSION['formdata'] = $_SESSION['formdata'].'form data is clean<br>';

// check if email exists
$email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '$_email' ");
$rowCount = mysqli_num_rows($email_check_query);

	// check if user email already exists
	if($rowCount > 0) {
		$_SESSION['email_exist'] = '
			<div class="alert alert-danger" role="alert">
				User with that email already exists!
			</div>';
		header("Location: https://syntheticreality.net/portal/signup.php");
		exit;
	}
	$_SESSION['formdata'] = $_SESSION['formdata'].'email is new<br>';

		include '/opt/bitnami/apache2/htdocs/portal/controllers/get_ip_address.php';
		// Generate random activation token
		$token = md5(rand().time());

		// Password hash
		$password_hash = password_hash($_password, PASSWORD_BCRYPT);

		// get user ip address
		$link = get_ip_address();

		// Query
		$sql = "INSERT INTO users (firstname, lastname, email, mobilenumber, link, password, token, is_active, date_time, created, modified) VALUES ('$firstname', '$lastname', '$_email', '$mobilenumber', '$link', '$password_hash', '$token', '0', now(), now(), now())";
		
		// Create mysql query
		$sqlQuery = mysqli_query($connection, $sql);
		
		if(!$sqlQuery){
			die("MySQL query failed!" . mysqli_error($connection));
		} 
		$_SESSION['formdata'] = $_SESSION['formdata']. $sql.'<br>';		
		//$_SESSION['formdata'] = 'updated DB';
		$_SESSION['email'] = $_email;
		$email = $_SESSION['email'];

		// Send verification email
		if($sqlQuery) {
			// Create the Verify Request Mail
			$from    = 'noreply@syntheticreality.net';
			$subject = 'Please Verify Your Email Address';
			$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			// Update the activation variable below
			$message = '<p>Please use the activation link to verify your email: <a href="https://syntheticreality.net/portal/user_verification.php?token='.$token.'"> Click to verify email</a></p>';

			mail($email, $subject, $message, $headers);
			$_SESSION['email_verify_success'] = '<div class="alert alert-success">
			<h2>User Profile created!</h2></div><div class="alert alert-primary">
					 <h2>A Verification email has been sent!<br><br>Please check your email to activate your account!</h2>
				</div>';
		}
}
	header("Location: https://syntheticreality.net/portal/signup.php");

?>