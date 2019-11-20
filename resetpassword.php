<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
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
	<form action="#" method="post">
		<div class="container">
		  <h1>Reset Password</h1>
		  <p>Please fill in this form to reset you password.</p>
		  <hr>
		  <label for="Password"><b>Enter New Password</b></label>
		  <input type="password" placeholder="Enter Password" name="pass" 
		  pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
		  title="Must contain at least one number,one uppercase, one lowercase letter, one special character and at least 8 or more characters" required>
          <div class="clearfix">
		  <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
			<button type="submit" name="submit" class="signupbtn">Reset</button>
		  </div>
		</div>
	</form>
	<?php
		require "config/database.php";
		$hash = $_SESSION["hash"]; 
		$hashcheck = $_GET['hash'];
		if ($hash == $hashcheck)
		{
			if (isset($_POST['submit']))
			{
				$password = md5(htmlspecialchars($_POST[pass]));
				$email = htmlspecialchars($_GET[email]);
				try 
				{
					$result = 0;
					$conn = new PDO($db_host, $db_username, $db_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE users SET password=:password WHERE email = :email";
					$stm = $conn->prepare($sql);
					$stm->bindParam(':email', $email);
					$stm->bindParam(':password', $password);
					$result = $stm->execute();
					if ($result)
					{
						session_destroy();
						echo '<script>alert("Your password has been reset.")
						location.replace("login.php")</script>';
					}
				}
				catch (PDOException $e)
				{
					echo '<script>alert("An error occured.")</script>';
				}
				$conn->close();
			}
		}			
		else
			echo '<script>alert("You have already used this link.")
			location.replace("index.php")</script>';
	?>
</body>
</html>