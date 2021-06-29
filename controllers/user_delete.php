<?php     if(!isset($_SESSION)) {
        session_start();
    }
 ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>Delete User</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>

<body>
   
<div class="container mt-5">
	<div class="d-flex justify-content-center">
		<div class="card" style="width: 25rem">
			<div class="card-body">
				<h2 class="card-title text-center mb-4">Delete User Account</h2>
				<h3 class="card-subtitle mb-2 text-muted">Hello<br>
				<?php if(isset($_SESSION['firstname'])) {echo $_SESSION['firstname'].' ';}
				  if(isset($_SESSION['lastname'])) {echo $_SESSION['lastname'];} ?></h3>
				<p class="card-text">Email address: <?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];} ?></p>
				<p class="card-text">Mobile number: <?php if(isset($_SESSION['mobilenumber'])) {echo $_SESSION['mobilenumber'];} ?></p>
				
			   <a class="btn btn-primary btn-block text-center mb-4" href="dashboard.php"><h3>Cancel Delete</h3></a><br>

				<form action="deluser.php" method="post">
                <div class="form-group">
                <label><p class="card-text alert alert-danger text-dark"><strong>The Account Deletion cannot be undone!<br>This action will delete your user account and all content associated with the account.</strong></p></label>
                <input type="deluser" class="form-control" name="deluser" id="deluser" value="deluser" hidden />
				</div>
				<br><br>
                <button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block"><h2>Delete My Account</h2>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
