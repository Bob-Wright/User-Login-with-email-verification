<?php include('/opt/bitnami/apache2/htdocs/portal/controllers/passwd_activation.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>Change Password</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>
<body>
<div class="App">
	<div class="vertical-center">
		<div class="inner-block">
			<?php $_SESSION['email_paswd_success'] = '';
			if(isset($_SESSION['passwd_verified'])) {
				echo $_SESSION['passwd_verified'].
                    '<br><a class="nav-link" href="./index.php"><h2>Sign in</h2></a>';
			} else {
			echo
			'<form action="" method="post">'.
				'<h1>Change Password</h1>'.
				'<h2>If you do not want to change your password, please close the browser!</h2>'.
			'<div class="form-group">'.
			'<label>Password</label>'.
			'<input type="password" class="form-control" name="password" id="password" />';

			if(isset($_SESSION['passwordErr'])) { echo $_SESSION['passwordErr'];}
			if(isset($_SESSION['passwordEmptyErr'])) { echo $_SESSION['passwordEmptyErr'];}
			if(isset($_SESSION['passwd_change_error'])) { echo $_SESSION['passwd_change_error'];}
			echo
			'</div>'.
			'<br><br>'.
			'<button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block"><h2>Change Password</h2>'.
			'</button>'.
			'</form>';
			}
?>
</body>
</html>
