<?php if(!isset($_SESSION)) {session_start();} ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>User Registration</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>
<body>
   <?php
   if($_SESSION['email_verify_success'] == '') {
   include('/opt/bitnami/apache2/htdocs/portal/header.php'); }
   ?>
<div class="App">
	<div class="vertical-center">
		<div class="inner-block">
		<h1>User Data</h1>
			<?php
			if($_SESSION['email_verify_success'] != '') {
				echo $_SESSION['email_verify_success'];
			} else {
			echo
			'<form action="https://syntheticreality.net/portal/controllers/register.php" method="post">';

			if($_SESSION['modify_success'] != '') { echo $_SESSION['modify_success'];}
			if($_SESSION['email_exist'] != '') { echo $_SESSION['email_exist'];}
			if($_SESSION['email_verify_err'] != '') { echo $_SESSION['email_verify_err'];}
			echo
			'<div class="form-group">'.
			'<label>First name</label>'.
			//'<div class="alert alert-primary">Only letters and white space allowed.</div>'.
			'<input type="text" class="form-control" name="firstname" id="firstName" required value="'. $firstname .'" />';
			if($_SESSION['f_NameErr'] != '') { echo $_SESSION['f_NameErr'];}
			if($_SESSION['fNameEmptyErr'] != '') { echo $_SESSION['fNameEmptyErr'];}
			echo
			'</div>'.

			'<div class="form-group">'.
			'<label>Last name</label>'.
			//'<div class="alert alert-primary">Only letters and white space allowed.</div>'.
			'<input type="text" class="form-control" name="lastname" id="lastName" required value="'. $lastname.'" />';
			if($_SESSION['l_NameErr'] != '') { echo $_SESSION['l_NameErr'];}
			if($_SESSION['lNameEmptyErr'] != '') { echo $_SESSION['lNameEmptyErr'];}
			echo
			'</div>'.

			'<div class="form-group">'.
			'<label>Email</label>'.
			//'<div class="alert alert-primary">Valid Email address format only.</div>'.
			'<input type="email" class="form-control" name="email" id="email" required value="'. $email.'" />';
			if($_SESSION['_emailErr'] != '') { echo $_SESSION['_emailErr'];}
			if($_SESSION['emailEmptyErr'] != '') { echo $_SESSION['emailEmptyErr'];}
			echo
			'</div>'.

			'<div class="form-group">'.
			'<label>Mobile</label>'.
			//'<div class="alert alert-primary">Only 10-digit mobile numbers allowed.</div>'.
			'<input type="text" class="form-control" name="mobilenumber" id="mobilenumber" required value="'.$mobilenumber.'" />';
			if($_SESSION['_mobileErr'] != '') { echo $_SESSION['_mobileErr'];}
			if($_SESSION['mobileEmptyErr'] != '') { echo $_SESSION['mobileEmptyErr'];}
			echo
			'</div>'.
			
			'<div class="form-group">'.
			'<label>Password</label>'.
			'<div class="alert alert-primary">6 to 20 characters, both lowercase and uppercase, and at least one of @#!%& and a digit.</div>'.
			'<input type="password" class="form-control" name="password" id="password" required />';

			if(isset($_SESSION['_passwordErr'])) { echo $_SESSION['_passwordErr'];}
			if(isset($_SESSION['passwordEmptyErr'])) { echo $_SESSION['passwordEmptyErr'];}
			echo
			'</div>'.
			'<br>';
			if($_SESSION['email_verify_success'] == '') {
			echo
			'<button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block"><h2>Sign up</h2></button>'.
			'</form>';
			}
			}
			?>
		</div>
	</div>
</div>
</body>
</html>
