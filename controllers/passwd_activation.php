<?php
// Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php');

// GET the token = ?token
if(!empty($_GET['token'])){
   $token = $_GET['token'];
} else {
	$token = "";
	header("Location: https://syntheticreality.net/portal/index.php");
	exit;
}
$_SESSION['passwordEmptyError'] = '';

if(isset($_POST["submit"]) && isset($_POST["password"])) {
	$password      = $_POST["password"];
		if(empty($password)){
			$_SESSION['passwordEmptyErr'] = '<div class="alert alert-danger">
				Password cannot be blank.
			</div>';
			return;
		}            

$_SESSION['_passwordErr'] = '';

	if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#!%&])[A-Za-z0-9@#!%&]{6,20}$/", $password)) {
		$_SESSION['passwordErr'] = '<div class="alert alert-danger">
				 Password should be between 6 to 20 characters long, both lowercase and uppercase, and contain at least one special chacter (@#!%&) and a digit.
			</div>';
			return;
	} else {
	// Password hash
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	// Generate random activation token
	$nutoken = md5(rand().time());

	$sqlQuery = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token' ");
	$countRow = mysqli_num_rows($sqlQuery);

	if($countRow == 1){
		while($rowData = mysqli_fetch_array($sqlQuery)){
			$update = mysqli_query($connection, "UPDATE users SET password = '$password_hash', token = '$nutoken' WHERE token = '$token' ");
			if($update){
			   $_SESSION['passwd_verified'] = '<div class="alert alert-success">
					  User password changed
					</div>
			   ';
			}
		}
	} else {
	   $_SESSION['passwd_verified'] = '<div class="alert alert-success">
		  Verification error
		</div>
	   ';
	}
}
}
?>