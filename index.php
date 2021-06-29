<?php if(!isset($_SESSION)) {session_start();} ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://syntheticreality.net/portal/css/style.css">
    <title>Login</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://syntheticreality.net/portal/js/jquery.min.js"></script>
    <script src="https://syntheticreality.net/portal/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
	console.info( "we are ready!" );
$(window).resize(function() {

  var viewportWidth = $(window).width();
  var vpWidth = parseInt(viewportWidth);
  var viewportHeight = $(window).height();
  var vpHeight = parseInt(viewportHeight);
  
	// Display the "matrix" screen
	var ctx = c.getContext("2d");
	// full screen canvas
	c.height = vpHeight;
	c.width = vpWidth;
	//character set
	var character = "0123456789@#$%^&?©ΓειάσουΚόσμε田由甲申甴电甶男甸甹町画甼甽甾甿畀畁畂畃畄畅畆畇畈畉畊畋界畍畎畏畐畑مرحبابالعالمПрывітаннеСусветСәлемӘлемសួស្តី​ពិភពលោកಹಲೋ ವರ್ಲ್ಡ್안녕하세요월드ສະ​ບາຍ​ດີ​ຊາວ​ໂລກ";
	//array of characters
	character = character.split("");
	var font_size = 26;
	var columns = c.width/font_size; //number of columns for the rain
	//an array of drops - one per column
	var drops = [];
	//x below is the x coordinate
	//1 = y co-ordinate of the drop(same for every drop initially)
	for(var x = 0; x < columns; x++) {
	drops[x] = 1;}
	//draw the characters
	function draw(){
		//Black BG for the canvas
		//translucent BG to show trail
		var opacity = 0.01;
		if(Math.random() > 0.9) {
		var opacity = 0.075};
		ctx.fillStyle = "rgba(0, 0, 0, "+opacity+")";
		ctx.fillRect(0, 0, c.width, c.height);
		//	var color = (Math.floor(Math.random()*10));
		//	if(color > 5) {ctx.fillStyle = "#F80";} else {ctx.fillstyle = "#0ff";}
		ctx.fillStyle = "#fff"; // text
			var color = (Math.floor(Math.random()*10));
			if(color == 9) {ctx.fillStyle = "#0ff";}
			if(color == 8) {ctx.fillStyle = "#8f0";}
			if(color == 7) {ctx.fillStyle = "#a3d";}
			if(color == 6) {ctx.fillStyle = "#e23";}
			if(color == 5) {ctx.fillStyle = "#f90";}
			if(color == 4) {ctx.fillStyle = "#ff1";}
			if(color == 3) {ctx.fillStyle = "#29f";}
			if(color == 2) {ctx.fillStyle = "#f0f";}
			if(color == 1) {ctx.fillStyle = "#f50";}
		ctx.font = font_size + "px arial";
		//looping over drops
		for(var i = 0; i < drops.length; i++){
			//a random character to print
			var text = character[Math.floor(Math.random()*character.length)];
			//x = i*font_size, y = value of drops[i]*font_size
			ctx.fillText(text, i*font_size, drops[i]*font_size);
			//sending the drop back to the top randomly after it has crossed the screen
			//adding a randomness to the reset to make the drops scattered on the Y axis
			if(drops[i]*font_size > c.height && Math.random() > 0.75)
				drops[i] = 0;
			//incrementing Y coordinate
			if(drops[i] > 6 && (Math.random() > 0.9)) {
			drops[i] = drops[i] - 6;}
			drops[i]++;
		}
	}
	setInterval(draw, 80);
}).trigger('resize');
    setTimeout(function () {$(".matrix").show(0)});
});
</script>
</head>
<body>
	<section class="matrix" title="Drop character screen like the matrix.">
		<canvas id="c" height="100vh" width="100vw" style="z-index: -5;"></canvas>
	</section>
   <?php
   if($_SESSION['email_verify_success'] == '') {
   include('/opt/bitnami/apache2/htdocs/portal/header.php'); }
   ?>
    <!-- Login form -->
    <div class="App" style="z-index: 5; position: absolute; top: 1vh;">
        <div class="vertical-center">
            <div class="inner-block">
                <?php if($_SESSION['email_paswd_success'] != '') {echo $_SESSION['email_paswd_success'];
				} else {
                echo
                '<form action="controllers/login.php" method="post">'.
                    '<h1>Hello and Welcome!</h1>';
					if(isset($_SESSION['emailPwdErr'])) {echo $_SESSION['emailPwdErr'];}
                    if(isset($_SESSION['verificationRequiredErr'])) {echo $_SESSION['verificationRequiredErr'];}
					if(isset($_SESSION['accountNotExistErr'])) {echo $_SESSION['accountNotExistErr'];}
					echo
                    '<div class="form-group">'.
                        '<label>Email</label>'.
                        '<input type="email" class="form-control" name="email_signin" id="email_signin" required />'.
                    '</div>';
					if(isset($_SESSION['email_empty_err'])) {echo $_SESSION['email_empty_err'];}
					echo
                    '<div class="form-group">'.
                        '<label>Password</label>'.
                        '<input type="password" class="form-control" name="password_signin" id="password_signin" />'.
                    '</div>';
					if(isset($_SESSION['pass_empty_err'])) {echo $_SESSION['pass_empty_err'];}
					echo
					'<br>'.
                    '<button type="submit" name="login" id="sign_in" class="btn btn-outline-primary btn-lg btn-block"><h2>Sign in</h2></button>'.
                    '<button type="submit" name="chpwd" id="chg_pwd" class="btn btn-outline-danger btn-lg btn-block"><h2>Change Password</h2></button>'.
				'</form>';}
			echo	
            '</div>'.
        '</div>'.
    '</div>';
?>
</body>
</html>
