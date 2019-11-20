<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Change Username</title>
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
		  <h1>Change Username</h1>
		  <p>Please fill in this form to change your username.</p>
		  <hr>
		  <label for="username"><b>Username</b></label>
		  <input type="text" placeholder="Enter Username" name="username" 
		  pattern="[a-zA-Z0-9]{5,}"
		  title="Must contain only letters and numbers, and must be ar least 5 characters long" required>
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
			$username = htmlspecialchars($_POST[username]);
			$old = $_SESSION["username"];
			if ($username == $old)
			{
				echo '<script>alert("Your new username cannot be the same as your old username.")</script>';
			}
			else
			{
				try 
				{
					$result = 0;
					$conn = new PDO($db_host, $db_username, $db_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE users SET username=:username WHERE username = :old";
					$stm = $conn->prepare($sql);
					$stm->bindParam(':username', $username);
					$stm->bindParam(':old', $old);
					$result = $stm->execute();
					if ($result)
					{
						$_SESSION["username"] = $username;
						echo '<script>alert("Your username has been changed.")
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