<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Change Email</title>
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
		  <h1>Change Email</h1>
		  <p>Please fill in this form to change your email.</p>
		  <hr>
		  <label for="email"><b>Email</b></label>
		  <input type="email" placeholder="Enter Email" name="email" required>
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
			$email = htmlspecialchars($_POST[email]);
			$username = $_SESSION["username"];
			$hash = md5(date('YmdHis'));
			if ($email == $_SESSION["email"])
			{
				echo '<script>alert("Your new email cannot be the same as your old email.")</script>';
			}
			else
			{
				try 
				{
					$result = 0;
					$conn = new PDO($db_host, $db_username, $db_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE users SET email=:email, active=0 WHERE username = :username";
					$stm = $conn->prepare($sql);
					$stm->bindParam(':email', $email);
					$stm->bindParam(':username', $username);
					$result = $stm->execute();
					if ($result)
					{
						$to = $email;
						$subject = 'Swiftly | Change Email'; 
						$message = '
						<br>
						Your account has been updated, you can login with the following credentials after you have activated your new email by pressing the url below.<br>
						<br>
						------------------------<br>
						Username: '.$username.'<br>
						Email: '.$email.'<br>
						------------------------<br>
						<br>
						Please click this link to activate your new email:<br>
						http://localhost:8080/camagru/verify.php?email='.$email.'&hash='.$hash.'<br>
						<br>
						';
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";
						$headers .= "From: <no-reply@camagru.com>"."\r\n";
						if (mail($to, $subject, $message, $headers))
						{	
							$_SESSION["hash"] = $hash;
							$_SESSION["sess"] = false;
							echo '<script>alert("Your email has been changed. You have been logged out. Please click the link sent to your new email to verify your account.")
							location.replace("profile.php")</script>';
						}
						else 
							echo '<script>alert("Error")</script>';
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