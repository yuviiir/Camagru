<?php
	session_start();
	if ($_SESSION["sess"])
	{
		$pid = $_GET["pic"];
		require "config/database.php";
		$conn = new PDO($db_host, $db_username, $db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT picture FROM pictures WHERE pid= :pid";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':pid', $pid);
		$stm->execute();
		$pic = "img/uploads/".$stm->fetchColumn();
        $sql = "DELETE FROM comments WHERE pid = :pid";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':pid', $pid);
        $stm->execute(); 
        $sql = "DELETE FROM likes WHERE pid = :pid";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':pid', $pid);
		$stm->execute(); 
		$sql = "DELETE FROM pictures WHERE pid = :pid";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':pid', $pid);
		$stm->execute(); 
		unlink($pic);
		header("Location: profile.php");
	}
	else
	{
		echo '<script>alert("Error.")
        location.replace("profile.php")</script>';
	}
?>