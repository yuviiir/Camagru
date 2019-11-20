<?php
	session_start();
	if ($_SESSION["sess"])
	{
		$uid = $_SESSION["uid"];
		$pid = $_GET["pic"];
		$num = $_GET["num"];
		require "config/database.php";
		$conn = new PDO($db_host, $db_username, $db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO camagru.likes (pid, uid)
			VALUES (:pid, :uid)";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':pid', $pid);
		$stm->bindParam(':uid', $uid);
		$stm->execute(); 
		header("Location: index.php?num=$num");
	}
	else
	{
		echo '<script>alert("Error.")
        location.replace("index.php?num='.$num.'")</script>';
	}
?>