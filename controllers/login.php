<?php

// Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php');

global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;
$_SESSION['wrongPwdErr'] = '';
$_SESSION['accountNotExistErr'] = '';
$_SESSION['emailPwdErr'] = '';
$_SESSION['verificationRequiredErr'] = '';
$_SESSION['email_empty_err'] = '';
$_SESSION['pass_empty_err'] = '';

if(isset($_POST['chpwd']) && isset($_POST['email_signin'])) {
	$email_signin        = $_POST['email_signin'];
	$semail = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
	$user_email = filter_var($semail, FILTER_VALIDATE_EMAIL);
	// Query if email exists in db
	$sql = "SELECT * From users WHERE email = '{$user_email}' ";
	$query = mysqli_query($connection, $sql);
	$rowCount = mysqli_num_rows($query);
	// If query fails, show the reason 
	if(!$query){
	   die("SQL query failed: " . mysqli_error($connection));
	}
	//echo '<br>'.$user_email.' - '.$pswd.'<br>';
	// Check if email exists
	if($rowCount <= 0) {
		$_SESSION['accountNotExistErr'] = '<div class="alert alert-danger">
				User account does not exist.
			</div>';
		header("Location: https://syntheticreality.net/portal/index.php");
		exit;
		//echo $accountNotExistErr;
	} else {
		// Fetch user data and store in php session
		//echo '<br>Fetching user from DB<br>';
		while($row = mysqli_fetch_array($query)) {
			$id            = $row['id'];
			$firstname     = $row['firstname'];
			$lastname      = $row['lastname'];
			$email         = $row['email'];
			$mobilenumber   = $row['mobilenumber'];
			$link          = $row['link'];
			$pass_word     = $row['password'];
			$token         = $row['token'];
			$is_active     = $row['is_active'];
		}
	if($is_active == 0) {
		// resend verification email
			// Create the Verify Request Mail
			$from    = 'noreply@syntheticreality.net';
			$subject = 'Please Verify Your Email Address';
			$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			// Update the activation variable below
			$message = '<p>Please use the activation link to verify your email: <a href="https://syntheticreality.net/portal/user_verification.php?token='.$token.'"> Click to verify email</a></p>';

			mail($email, $subject, $message, $headers);
			$_SESSION['email_paswd_success'] = '<div class="alert alert-success">
				 <h2>The user account must be verified before the password can be changed.</h2><h3>Please check your email for a link to verify your account.</h3>
			</div>';
		//echo $_SESSION['email_paswd_success'];
		header("Location: https://syntheticreality.net/portal/index.php");
		exit;
	}

		// Create the Verify Request Mail
		$from    = 'noreply@syntheticreality.net';
		$subject = 'Verify Password Change Request';
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$message = '<p>Please use the link to change your password.<br>If you do not want to change your password ignore this emai!: <a href="https://syntheticreality.net/portal/passwd_verification.php?token='.$token.'"> Click to Change Password.</a></p>';

		mail($email, $subject, $message, $headers);
		$_SESSION['email_paswd_success'] = '<div class="alert alert-success">
				 <h2>An email has been sent to validate your request.</h2><h3>Please check your email for a link to change your password.</h3>
			</div>';
		//echo $_SESSION['email_paswd_success'];
		header("Location: https://syntheticreality.net/portal/index.php");
		exit;
	}
}
if(isset($_POST['login']) && isset($_POST['email_signin']) && isset($_POST['password_signin'])) {
	$email_signin        = $_POST['email_signin'];
	$semail = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
	$user_email = filter_var($semail, FILTER_VALIDATE_EMAIL);
	$password_signin     = $_POST['password_signin'];
	//echo '<br>'.$email_signin.' - '.$password_signin.'<br>';
	$pswd = mysqli_real_escape_string($connection, $password_signin);

	// Query if email exists in db
	$sql = "SELECT * From users WHERE email = '{$user_email}' ";
	$query = mysqli_query($connection, $sql);
	$rowCount = mysqli_num_rows($query);
	// If query fails, show the reason 
	if(!$query){
	   die("SQL query failed: " . mysqli_error($connection));
	}

	if(!empty($email_signin) && !empty($password_signin)){
		if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=!\?]{6,20}$/", $pswd)) {	$_SESSION['wrongPwdErr'] = '<div class="alert alert-danger">
					Password should be between 6 to 20 charcters long, both lowercase and uppercase, and contain at least one special character and a digit.
				</div>';
			//echo $wrongPwdErr;
		}
	//echo '<br>'.$user_email.' - '.$pswd.'<br>';
		// Check if email exists
		if($rowCount <= 0) {
			$_SESSION['accountNotExistErr'] = '<div class="alert alert-danger">
					User account does not exist.
				</div>';
			header("Location: https://syntheticreality.net/portal/index.php");
			exit;

			//echo $accountNotExistErr;
		} else {
			// Fetch user data and store in php session
			//echo '<br>Fetching user from DB<br>';
			while($row = mysqli_fetch_array($query)) {
				$id            = $row['id'];
				$firstname     = $row['firstname'];
				$lastname      = $row['lastname'];
				$email         = $row['email'];
				$mobilenumber   = $row['mobilenumber'];
				$link          = $row['link'];
				$pass_word     = $row['password'];
				$token         = $row['token'];
				$is_active     = $row['is_active'];
			}
	//echo '<br>'.$email.' - '.$pass_word.'<br>';

			// Verify password
			$ptest = password_verify($pswd, $pass_word);
			//if($ptest == true) { echo '<br>Valid Password hash<br>'; } else { echo '<br>Invalid Password hash<br>';};
			
			// Allow only verified user
			if($is_active == '1') {
				if($user_email == $email && $ptest == true) {
				   $_SESSION['id'] = $id;
				   $_SESSION['firstname'] = $firstname;
				   $_SESSION['lastname'] = $lastname;
				   $_SESSION['email'] = $email;
				   $_SESSION['mobilenumber'] = $mobilenumber;
				   $_SESSION['link'] = $link;
				   $_SESSION['token'] = $token;
				   header("Location: https://syntheticreality.net/portal/controllers/dashboard.php");
				   exit;

				} else {
					//echo $emailPwdErr;
					$_SESSION['emailPwdErr'] = '<div class="alert alert-danger">
							User validation failed.
						</div>';
					header("Location: https://syntheticreality.net/portal/index.php");
					exit;
				}
			} else {
			//echo $verificationRequiredErr;
			$_SESSION['verificationRequiredErr'] = '<div class="alert alert-danger">
					Account verification is required before you can login.
				</div>';
			header("Location: https://syntheticreality.net/portal/index.php");
			exit;
			}
		}
	}
}

	//echo $email_empty_err;
if(empty($email_signin)){
	$_SESSION['email_empty_err'] = "<div class='alert alert-danger email_alert'>
				Email not provided.
		</div>";
}
	//echo $pass_empty_err;
if(empty($password_signin)){                                                                      
	$_SESSION['pass_empty_err'] = "<div class='alert alert-danger email_alert'>
				Password not provided.
			</div>";
}            
header("Location: https://syntheticreality.net/portal/index.php");
?>