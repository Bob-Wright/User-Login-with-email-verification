<?php
// Database connection
include('/opt/bitnami/apache2/htdocs/portal/config/db.php');
$_SESSION['modify_success'] = '';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>User Registration Portal</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>
<body>
   <?php //include('/opt/bitnami/apache2/htdocs/portal/header.php');
	$user_email = $_SESSION['email'];
	$_SESSION['email_verify_success'] = '';
	// Query if email exists in db
	$sql = "SELECT * From users WHERE email = '$user_email' ";
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
			$_SESSION['id']            = $row['id'];
			$_SESSION['firstname']     = $row['firstname'];
			$_SESSION['lastname']      = $row['lastname'];
			$_SESSION['email']         = $row['email'];
			$_SESSION['mobilenumber']   = $row['mobilenumber'];
			$_SESSION['link']          = $row['link'];
		}
	}
?>

<div class="container mt-5">
	<div class="d-flex justify-content-center">
		<div class="card" style="width: 45vw">
			<div class="card-body">
				<h2 class="card-title text-center mb-4">User Profile</h2>
				<h3 class="card-subtitle mb-2 text-muted">Welcome<br>
				<?php if(isset($_SESSION['firstname'])) {echo $_SESSION['firstname'].' ';}
				  if(isset($_SESSION['lastname'])) {echo $_SESSION['lastname'];} ?></h3>
				<p class="card-text">Email address: <?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];} ?></p>
				<p class="card-text">Mobile number: <?php if(isset($_SESSION['mobilenumber'])) {echo $_SESSION['mobilenumber'];} ?></p>
				<p class="card-text alert alert-success text-dark"><strong>The user data shown above will be associated with the content you post in the application.<br><br>However, only your name along with your content is displayed to site visitors.</strong></p>
				<a class="btn btn-outline-success btn-block text-center mb-4" href="#"><h3>Continue to the application</h3></a><br>
			   <a class="btn btn-outline-primary btn-block text-center mb-4" href="logout.php"><h3>Log out of the application</h3></a><br>
			   <a class="btn btn-outline-primary btn-block text-center mb-4" href="modify.php"><h3>Change My Profile Data</h3></a><br>
				<a class="btn btn-outline-danger btn-block text-center mb-4" href="user_delete.php"><h3>Delete My User Account</h3></a>
				<!--<p class="card-text alert alert-danger"><strong>Delete This User Account action cannot be undone!</strong></p> -->
			</div>
		</div>
	</div>
</div>

</body>

</html>