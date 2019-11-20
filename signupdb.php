<?php
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
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
$email = htmlspecialchars($_POST[email]);
$username =  htmlspecialchars($_POST[username]);
$password = md5(htmlspecialchars($_POST[pass]));
$hash = md5(date('YmdHis'));
try
{
	$conn = new PDO($db_host, $db_username, $db_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "INSERT INTO camagru.users (email, username, password)
		VALUES (:email, :username, :password)";
	$stm = $conn->prepare($sql);
	$stm->bindParam(':email', $email);
	$stm->bindParam(':username', $username);
	$stm->bindParam(':password', $password);
	if ($stm->execute())
	{
		$to = $email;
		$subject = 'Swiftly | Verification'; 
		$message = '
		<br>
		Thanks for signing up!<br>
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.<br>
		<br>
		------------------------<br>
		Username: '.$username.'<br>
		Email: '.$email.'<br>
		------------------------<br>
		<br>
		Please click this link to activate your account:<br>
		http://localhost:8080/camagru/verify.php?email='.$email.'&hash='.$hash.'<br>
		<br>
		';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";
		$headers .= "From: <no-reply@camagru.com>"."\r\n";
		if (mail($to, $subject, $message, $headers))
		{
			$_SESSION["hash"] = $hash;
			echo '<div class="signin">You account has been successfully created. Please click the link sent to your email to verify you account.</div>
			<br><a href="login.php"><button class="button">Log In</button></a>';
		}
		else 
			echo '<div class="signin">Mail not sent.</div>';
	}
}
catch (PDOException $e)
{
	echo '<div class="signin"><a>Email or username is already in use.</a></div>
	<br><a href="login.php"><button class="button">Log In</button></a>';
}
$conn->close();
?>
</html>