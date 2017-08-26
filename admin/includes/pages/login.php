<?php if (User::isLogged()) {header("Location: index.php");} 

$the_message="Username e password errati";
echo print_r($_SESSION['login']);
if(isset($_POST['submit'])){

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	User::login($username,$password);

	if (User::isLogged()) {header("Location: index.php");}
	else echo "ERRORE";

	echo print_r($_SESSION['login']);
}

?>


<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php echo $the_message; ?></h4>
	
	<form id="login-id" action="" method="post">
		
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
			
		</div>


		<div class="form-group">
			<input type="submit" name="submit" value="Submit" class="btn btn-primary">

		</div>


	</form>


</div>