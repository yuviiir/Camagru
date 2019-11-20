<?php
        session_start();
        $uid = $_SESSION["uid"];
        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        
        $filename = date('YmdHis').'.png';
        
        file_put_contents('img/uploads/'.$filename, $data);
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
?>
