<?php
    // Database connection
    include('/opt/bitnami/apache2/htdocs/portal/config/db.php');

if((isset($_POST["submit"])) && ($_POST["deluser"] == "deluser")) {

	// check if email exists
if(isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$semail = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($semail, FILTER_VALIDATE_EMAIL);
	if(empty($email)) {	exit;}
	}
	// check if user email exists in db
	$email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
	$rowCount = mysqli_num_rows($email_check_query);
	if($rowCount == 1) {
	$delete = mysqli_query($connection, "DELETE FROM users WHERE email = '{$email}' ");
	}
	$email_check_query2 = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
	$rowCount = mysqli_num_rows($email_check_query2);
	if($rowCount == 0) {
		header("Location: https://syntheticreality.net/portal/controllers/logout.php");
		$_SESSION['email_exist'] = '
			<div class="alert alert-danger" role="alert">
				User was deleted!
			</div>';
		echo $_SESSION['email_exist'];
	}
}

?>