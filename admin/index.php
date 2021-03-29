<?php
session_start();
if (isset($_SESSION['admin'])) {
	header('location:home.php');
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition login-page" style=" background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../images/indexbg.jpg');">
	<div class="row">
		<h1></h1>
	</div>
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-12 col-md-offset-0 text-center">
				<div>
					<p class="display-1">RC Llaguno Construction</p>
					<p class="display-4"> Builders <i class="fa fa-circle mt-2" style="font-size:.5em;"></i> Designers <i class="fa fa-circle mt-2" style="font-size:.5em;"></i> Consultation</p>
				</div>
			</div>
		</div>
	</div>
	<div class="login-box">
		<div class="login-logo">
			<b>Admin Login</b>
		</div>

		<div class="login-box-body ">
			<p class="login-box-msg">Sign in to start your session</p>

			<form action="login.php" method="POST">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" name="username" placeholder="Input Username" required autofocus>
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" placeholder="Input Password" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-push-4">
						<button type="submit" class="btn btn-primary btn-block" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		if (isset($_SESSION['error'])) {
			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>" . $_SESSION['error'] . "</p> 
			  	</div>
  			";
			unset($_SESSION['error']);
		}
		?>
	</div>

	<?php include 'includes/scripts.php' ?>
</body>

</html>