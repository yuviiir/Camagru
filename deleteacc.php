<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Delete Account</title>
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
		  <h1>Delete Account</h1>
		  <p>Please fill in this form to delete your account.</p>
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
			$email = htmlspecialchars($_POST['email']);
			$uid = $_SESSION["uid"];
			if ($email == $_SESSION["email"])
			{
				try 
				{
					$result = 0;
					$conn = new PDO($db_host, $db_username, $db_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "DELETE FROM comments WHERE uid = :uid";
					$stm = $conn->prepare($sql);
					$stm->bindParam(':uid', $uid);
					$result = $stm->execute();
					if ($result)
					{
						$result = 0;
						$conn = new PDO($db_host, $db_username, $db_password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "DELETE FROM pictures WHERE uid = :uid";
						$stm = $conn->prepare($sql);
						$stm->bindParam(':uid', $uid);
						$result = $stm->execute();
						if ($result)
						{
							$result = 0;
							$conn = new PDO($db_host, $db_username, $db_password);
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = "DELETE FROM users WHERE uid = :uid";
							$stm = $conn->prepare($sql);
							$stm->bindParam(':uid', $uid);
							$result = $stm->execute();
							if ($result)
							{
								session_destroy();
								echo '<script>alert("Account successfully deleted.")
								location.replace("profile.php")</script>';
							}
						}
					}
				}
				catch (PDOException $e)
				{
					echo '<script>alert("An error occured.")</script>';
				}
			}
			else
			{
				echo '<script>alert("Email is entered incorrectly.")</script>';
			}
		$conn->close();
		}
	?>
</body>
</html>
<!-- // if ($result)
				// {
					// $result = 0;
					// $sql = "DELETE FROM pictures WHERE uid = :uid";
					// $stm = $conn->prepare($sql);
					// $stm->bindParam(':uid', $uid);
					// $result = $stm->execute();
					// if ($result)
					// {
					// 	$result = 0;
					// 	$sql = "DELETE FROM comments WHERE uid = :uid";
					// 	$stm = $conn->prepare($sql);
					// 	$stm->bindParam(':uid', $uid);
					// 	$result = $stm->execute();
					// 	if ($result)
					// 	{
					// 		session_destroy();
					// 		echo '<script>alert("Account successfully deleted.")
					// 		location.replace("profile.php")</script>';
					// 	}
					// 	else
					// 	echo "2";
					// }
					// else
					// echo "2";
				//}
				// else
				//  echo "1"; -->