<?php
// Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php');

// Error & success messages
$_SESSION['email_exist'] = ''; $_SESSION['f_NameErr'] = ''; $_SESSION['l_NameErr'] = ''; $_SESSION['_emailErr'] = ''; $_SESSION['_mobileErr'] = '';
$_SESSION['fNameEmptyErr'] = ''; $_SESSION['lNameEmptyErr'] = ''; $_SESSION['emailEmptyErr'] = ''; $_SESSION['mobileEmptyErr'] = '';
$_SESSION['email_verify_success'] = ''; $_SESSION['modify_success'] = '';
// Set empty form vars for validation mapping
$_first_name = $_last_name = $post_email = $_mobile_number = "";
$firstname = $lastname = $_email = $mobilenumber = "";

if(isset($_POST["submit"])) {
	$firstname     = $_POST["firstname"];
	$lastname      = $_POST["lastname"];
	$post_email    = $_POST["email"];
	$mobilenumber  = $_POST["mobilenumber"];
// Verify form values not empty
if(empty($firstname) || empty($lastname) || empty($post_email) || empty($mobilenumber)){
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
	//echo 'a value is empty<br>';
}	
$_SESSION['formdata'] = '<br>form data is present<br>';
}
	//clean the form data
	$_first_name = mysqli_real_escape_string($connection, $firstname);
	$_last_name = mysqli_real_escape_string($connection, $lastname);
	$_email = mysqli_real_escape_string($connection, $post_email);
	$_mobile_number = mysqli_real_escape_string($connection, $mobilenumber);

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
	
	// Store the data in db, if all the preg_match condition met
	if(($_SESSION['f_NameErr'] == '') && ($_SESSION['l_NameErr'] == '') && ($_SESSION['_emailErr'] == '') && ($_SESSION['_mobileErr'] == '')){

$_SESSION['formdata'] = $_SESSION['formdata'].'form data is clean<br>';

// check if email exists
$email = $_SESSION['email'];
if($email != $_email) {
	$email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '$_email' ");
	$rowCount = mysqli_num_rows($email_check_query);
	if($rowCount > 0) {
		$_SESSION['email_exist'] = '
			<div class="alert alert-danger" role="alert">
				User with that email already exists!
			</div>';
		header("Location: https://syntheticreality.net/portal/controllers/modify.php");
		exit;
	}
	$active = 0;
	$_SESSION['formdata'] = $_SESSION['formdata'].'email is different<br>';
} else {
$active = 1;
	$_SESSION['formdata'] = $_SESSION['formdata'].'email is same<br>';
}

		include '/opt/bitnami/apache2/htdocs/portal/controllers/get_ip_address.php';
		// Generate random activation token
		$token = md5(rand().time());
		// get user ip address
		$link = get_ip_address();

		// Query
		$sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$_email', mobilenumber = '$mobilenumber', link = '$link', token = '$token', is_active = '$active', modified = now() WHERE email = '$email' ";
		// Create mysql query
		$sqlQuery = mysqli_query($connection, $sql);
		if(!$sqlQuery){
			die("MySQL query failed!" . mysqli_error($connection));
		} 
		$_SESSION['formdata'] = $_SESSION['formdata']. $sql.'<br>';		
		//$_SESSION['formdata'] = 'updated DB';
		$_SESSION['email'] = $_email;
		$email = $_SESSION['email'];

		// user changed email address?
		// Send verification email
		if(($sqlQuery) && ($active == 0)) {
			// Create the Verify Request Mail
			$from    = 'noreply@syntheticreality.net';
			$subject = 'Please Verify Your Email Address';
			$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			// Update the activation variable below
			$message = '<p>Please use the activation link to verify your email: <a href="https://syntheticreality.net/portal/user_verification.php?token='.$token.'"> Click to verify email</a></p>';

			mail($email, $subject, $message, $headers);
			$_SESSION['email_verify_success'] = '<div class="alert alert-success">
					 <h2>A Verification email has been sent!<br><br>Please check your email to activate your account!</h2>
				</div>';
		}
		$_SESSION['modify_success'] = '<div class="alert alert-success">
			<h2>User Profile modified as shown!</h2>
		</div>';
}
	header("Location: https://syntheticreality.net/portal/controllers/modify.php");
?>