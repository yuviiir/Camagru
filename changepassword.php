<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
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
		  <h1>Change Password</h1>
		  <p>Please fill in this form to change your password.</p>
		  <hr>
		  <label for="psw"><b>Password</b></label>
		  <input type="password" placeholder="Enter Password" name="pass" 
		  pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
		  title="Must contain at least one number,one uppercase, one lowercase letter, one special character and at least 8 or more characters" required>
          <div class="clearfix">
		  <a href="settings.php"><button type="button" class="cancelbtn">Cancel</button></a>
			<button type="submit" name="submit" class="signupbtn">Reset</button>
		  </div>
		</div>
	</form>
	<?php
        require "config/database.php";
        if (isset($_POST['submit']))
        {
			$password = md5(htmlspecialchars($_POST[username]));
			$username = $_SESSION["username"];
			if ($password == $_SESSION["password"])
			{
				echo '<script>alert("Your new password cannot be the same as your old password.")</script>';
			}
			else
			{
				try 
				{
					$result = 0;
					$conn = new PDO($db_host, $db_username, $db_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE users SET password=:password WHERE username = :username";
					$stm = $conn->prepare($sql);
					$stm->bindParam(':password', $password);
					$stm->bindParam(':username', $username);
					$result = $stm->execute();
					if ($result)
					{
						$_SESSION["password"] = $password;
						echo '<script>alert("Your password has been changed.")
						location.replace("settings.php")</script>';
					}
				}
				catch (PDOException $e)
				{
					echo '<script>alert("An error occured.")</script>';
				}
			}
		$conn->close();
		}
	?>
</body>
</html>