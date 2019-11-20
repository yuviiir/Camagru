<?php
    $cid = $_GET["cid"];
    $pid = $_GET["pic"];
    require "config/database.php";
    $conn = new PDO($db_host, $db_username, $db_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "DELETE FROM comments WHERE cid = :cid";
	$stm = $conn->prepare($sql);
	$stm->bindParam(':cid', $cid);
    $stm->execute();
    header("Location: comment.php?pic=".$pid);
?>