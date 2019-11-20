<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
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
	$pid = $_GET["pic"];
    require "config/database.php";
    $conn = new PDO($db_host, $db_username, $db_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT uid FROM likes WHERE pid= :pid";
	$stm = $conn->prepare($sql);
	$stm->bindParam(':pid', $pid);
	$stm->execute();
	$arr = $stm->fetchAll();
	$i = 0;
	echo '<div class="signin">Likes</div><br>';
	while($arr[$i])
	{
		$uid = $arr[$i][0];
		$sql = "SELECT username FROM users WHERE uid= :uid";
		$stm = $conn->prepare($sql);
		$stm->bindParam(':uid', $uid);
		$stm->execute();
		$user = $stm->fetchColumn();
		echo '<div class="likes"><a href="search.php?search='.$user.'">@'.$user.'</a></div>';
		$i++;
	}
	if ($i == 0)
	{
		echo '<div class="likes">This post has no likes.</div>';
	}
?>