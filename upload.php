<?php
    session_start();
    $uid = $_SESSION["uid"];
	$location = "img/uploads/";
	$data = $location . basename($_FILES["file"]["name"]);
	$filename = ($_FILES["file"]["name"]);
	if (!$filename)
	{
		echo '<script>alert("No picture chosen.")
		location.replace("editor.php")</script>';
	}
	if (file_exists($data))
	{
		echo '<script>alert("Image already uploaded.")
		location.replace("editor.php")</script>';
	}
	else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], $data);
		require "config/database.php";
		$conn = new PDO($db_host, $db_username, $db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO camagru.pictures (uid, picture)
			VALUES (:uid, :picture)";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':uid', $uid);
		$stm->bindParam(':picture', $filename);
		if ($stm->execute())
					header("Location: imgsaved.php");
	}
?>