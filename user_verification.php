<?php include('/opt/bitnami/apache2/htdocs/portal/controllers/user_activation.php'); ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>Verification Status</title>

    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Email Verification Status</h1>
            <div class="col-12 mb-5 text-center">
                <?php if(isset($_SESSION['email_already_verified'])) {echo $_SESSION['email_already_verified'];}
					if(isset($_SESSION['email_verified'])) {echo $_SESSION['email_verified'];}
					if(isset($_SESSION['activation_error'])) {echo $_SESSION['activation_error'];} ?>
            </div>
            <p class="lead">Verified users may login.</p>
            <a class="btn btn-lg btn-success" href="./index.php">Click to Login</a>
        </div>
    </div>


</body>

</html>