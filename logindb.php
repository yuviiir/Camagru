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
require "config/database.php";
$username = htmlspecialchars($_POST['username']);
$pass = md5(htmlspecialchars($_POST['pass']));
try 
{
	$conn = new PDO($db_host, $db_username, $db_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT active FROM camagru.users WHERE username= :username AND password= :password";
	$stm = $conn->prepare($sql);
	$stm->bindParam(':username', $username);
	$stm->bindParam(':password', $pass);
	$stm->execute();
	$res = $stm->rowCount();
	if($res == 1)
	{	
		$result = $stm->fetchColumn();
		if ($result == true)
		{	
			$sql = "SELECT uid, email, notif FROM camagru.users WHERE username= :username AND password= :password";
			$stm = $conn->prepare($sql);
			$stm->bindParam(':username', $username);
			$stm->bindParam(':password', $pass);
			$stm->execute();
			$arr = $stm->fetchAll();
			$uid = $arr[0][0];
			$email = $arr[0][1];
			$notif = $arr[0][2];
			echo '<div class="signin">You have successfully logged in.</div>
			<br><a href="editor.php"><button class="button">Editor</button></a>';
			echo '<a href="index.php?num=1"><button class="button">Home</button></a>';
			echo '<a href="profile.php"><button class="button">Profile</button></a>';
			$_SESSION["sess"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["uid"] = $uid;
			$_SESSION["notif"] = $notif;
			$_SESSION["password"] = $pass;
			$_SESSION["username"] = $username;
			$_SESSION["hash"] = md5(date('YmdHis'));
		}
		else 
			echo '<div class="signin">Please click the verification link sent to you email.</div>
				<br><a href="login.php"><button class="button">Log In</button></a>';
	}
	else
		echo '<div class="signin">Incorrect information.</div>
		<br><a href="login.php"><button class="button">Retry</button></a>
		<a href="forgot.php"><button class="button">Forgot Password</button></a>';
}	
catch (PDOException $e)
{
	die("Error : " . $e->getMessage());	
}
$conn->close();
?>
</html>