<?php // Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php'); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>Change User Profile</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>
<body>
   <?php //include('/opt/bitnami/apache2/htdocs/portal/header.php');
	$email = $_SESSION['email'];
	// Query if email exists in db
	$sql = "SELECT * From users WHERE email = '$email' ";
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
		// Fetch user data
		//echo '<br>Fetching user from DB<br>';
		while($row = mysqli_fetch_array($query)) {
			$id            = $row['id'];
			$firstname     = $row['firstname'];
			$lastname      = $row['lastname'];
			$email         = $row['email'];
			$mobilenumber   = $row['mobilenumber'];
		}
	}
?>
	<div class="App">
        <div class="vertical-center">
            <div class="inner-block">
            <h1>Change User Data</h1>
                <?php
				if($_SESSION['email_verify_success'] != '') {
					echo $_SESSION['email_verify_success'];
				} else {
				echo
				'<form action="https://syntheticreality.net/portal/controllers/commit.php" method="post">';

				if($_SESSION['modify_success'] != '') { echo $_SESSION['modify_success'];}
                if($_SESSION['email_exist'] != '') { echo $_SESSION['email_exist'];}
                if($_SESSION['email_verify_err'] != '') { echo $_SESSION['email_verify_err'];}
				echo
                '<div class="form-group">'.
                '<label>First name</label>'.
                '<input type="text" class="form-control" name="firstname" id="firstName" required value="'. $firstname .'" />';
				if($_SESSION['f_NameErr'] != '') { echo $_SESSION['f_NameErr'];}
				if($_SESSION['fNameEmptyErr'] != '') { echo $_SESSION['fNameEmptyErr'];}
				echo
				'</div>'.

                '<div class="form-group">'.
                '<label>Last name</label>'.
                '<input type="text" class="form-control" name="lastname" id="lastName" required value="'. $lastname.'" />';
				if($_SESSION['l_NameErr'] != '') { echo $_SESSION['l_NameErr'];}
				if($_SESSION['lNameEmptyErr'] != '') { echo $_SESSION['lNameEmptyErr'];}
				echo
				'</div>'.

                '<div class="form-group">'.
                '<label>Email</label>'.
				'<input type="email" class="form-control" name="email" id="email" required value="'. $email.'" />';
				if($_SESSION['_emailErr'] != '') { echo $_SESSION['_emailErr'];}
				if($_SESSION['emailEmptyErr'] != '') { echo $_SESSION['emailEmptyErr'];}
				echo
				'</div>'.

                '<div class="form-group">'.
                '<label>Mobile</label>'.
				'<input type="text" class="form-control" name="mobilenumber" id="mobilenumber" required value="'.$mobilenumber.'" />';
				if($_SESSION['_mobileErr'] != '') { echo $_SESSION['_mobileErr'];}
				if($_SESSION['mobileEmptyErr'] != '') { echo $_SESSION['mobileEmptyErr'];}
				echo
				'</div>'.
				'<br><br>';
                if($_SESSION['email_verify_success'] == '') {
					echo
                '<button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block"><h2>Commit Changes</h2></button></form><br>'.
				'<a class="btn btn-outline-primary btn-block text-center mb-4" href="dashboard.php"><h3>Exit</h3></a>';
				} else {
				echo
				'</form><br>';
				}
				}
				?>
            </div>
        </div>
    </div>
</body>
</html>
