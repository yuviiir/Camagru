<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
	require "header.php";
?>
<script>
	elem = document.getElementById('profile');
	elem.classList.add('active');
</script>
	<?php
		if($_SESSION['sess'] == true)
		{
			echo '<div class="signin">You are already logged in.</div>
			<br><a href="index.php"><button class="button">Home</button></a>';
		}
		else
		{
			echo '<form action="logindb.php" method="post">
		<div class="container">
		  <h1>Log In</h1>
		  <p>Please fill in your details to log in to your account.</p>
		  <hr>
		  <label for="email"><b>Username</b></label>
		  <input type="text" placeholder="Enter Username" name="username"
		  pattern="[a-zA-Z0-9]{5,}"
		  title="Must contain only letters and numbers, and must be ar least 5 characters long" required>
	  
		  <label for="psw"><b>Password</b></label>
		  <input type="password" placeholder="Enter Password" name="pass" 
		  pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
		  title="Must contain at least one number,one uppercase, one lowercase letter, one special character and at least 8 or more characters" required>

		  <div class="clearfix">
		  <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
			<button type="submit" class="signupbtn">Log In</button>
		  </div>
		</div>
	  </form>';
		}
	?>
</body>
</html>