<?php
	session_start();
	$notif = $_SESSION["notif"];
	$email = $_SESSION["email"]; 
	require "config/database.php";
	$conn = new PDO($db_host, $db_username, $db_password);

	if ($notif == 1)
	{
		$sql = "UPDATE users SET notif=0 WHERE email = :email";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':email', $email);
		$stm->execute();
		$_SESSION["notif"] = 0;
	}
	else
	{
		$sql = "UPDATE users SET notif=1 WHERE email = :email";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':email', $email);
		$stm->execute();
		$_SESSION["notif"] = 1;
	}
	header("Location: settings.php");
?>