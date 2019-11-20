<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
	require "header.php";
?>
<script>
	elem = document.getElementById('home');
	elem.classList.add('active');
</script>
<?php
	require "config/database.php";
	if ($_GET["num"])
	{
		$num = $_GET["num"];
		$num1 = (5) * ($num) - 5;
		$conn = new PDO($db_host, $db_username, $db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM pictures ORDER BY pid DESC LIMIT 5 OFFSET $num1";
		$stm = $conn->prepare($sql);
		$stm->execute();
		$arrpic = $stm->fetchAll();
		$i = 0;
		while($arrpic[$i])
		{
			$postarr = $arrpic[$i];
			$pid = $postarr[0];
			$uid = $postarr[1];
			$sql = "SELECT * FROM likes WHERE pid= :pid";
			$stm = $conn->prepare($sql);
			$stm->bindParam(':pid', $pid);
			$stm->execute();
			$likes = $stm->rowCount();
			$sql = "SELECT * FROM comments WHERE pid= :pid";
			$stm = $conn->prepare($sql);
			$stm->bindParam(':pid', $pid);
			$stm->execute();
			$comments = $stm->rowCount();
			$sql = "SELECT username FROM users WHERE uid= :uid";
			$stm = $conn->prepare($sql);
			$stm->bindParam(':uid', $uid);
			$stm->execute();
			$user = $stm->fetchColumn();
			$pic = $postarr[2];
			$i++;
			if ($_SESSION["sess"])
			{
				$ssuser = $_SESSION["uid"];
				$sql = "SELECT * FROM likes WHERE uid= :uid AND pid= :pid";
				$stm = $conn->prepare($sql);
				$stm->bindParam(':uid', $ssuser);
				$stm->bindParam(':pid', $pid);			
				$stm->execute();
				$userlike = $stm->rowCount();
			
				if ($userlike)
				{
					echo '<br><div class="post"><div class="postimg">
					<p><a href="search.php?search='.$user.'">@'
					.$user.
					'</a></p>
					<img class="img" src="img/uploads/'.$pic.'">
					<a href="unlike.php?pic='.$pid.'&num='.$num.'"><button class="buttonpost">Unlike</button></a>
					<a href="comment.php?pic='.$pid.'&num='.$num.'"><button class="buttonpost">Comment</button></a><br>
					<div>Likes: '.$likes.'</div>
					<div>Comments: '.$comments.'</div>
					</div>
					</div><br>';
				}
				else
				{
					echo '<br><div class="post"><div class="postimg">
					<p><a href="search.php?search='.$user.'">@'
					.$user.
					'</a></p>
					<img class="img" src="img/uploads/'.$pic.'">
					<a href="like.php?pic='.$pid.'&num='.$num.'"><button class="buttonpost">Like</button></a>
					<a href="comment.php?pic='.$pid.'&num='.$num.'"><button class="buttonpost">Comment</button></a><br>
					<div>Likes: '.$likes.'</div>
					<div>Comments: '.$comments.'</div>
					</div>
					</div><br>';
				}
			}
			else{
				echo '<br><div class="post"><div class="postimg">
				<p><a href="search.php?search='.$user.'">@'
				.$user.
				'</a></p>
				<img class="img" src="img/uploads/'.$pic.'">
				<div><br>Likes: '.$likes.'</div>
				<div>Comments: '.$comments.'</div>
				</div>
				</div><br>';
			}
		}
		if ($i == 0)
		{
			echo '<div class="signin">No more posts.</div>';
		}
		if ($num == 1)
		{
			echo '<br><div class="center">
			<div class="pagination">
			<a href="index.php?num=1" class="active">1</a>
			<a href="index.php?num=2">2</a>
			<a href="index.php?num=3">3</a>
			<a href="index.php?num=4">4</a>
			<a href="index.php?num=5">5</a>
			</div>
		  </div>';
		}
		else if ($num == 2)
		{
			echo '<br><div class="center">
			<div class="pagination">
			<a href="index.php?num=1">1</a>
			<a href="index.php?num=2" class="active">2</a>
			<a href="index.php?num=3">3</a>
			<a href="index.php?num=4">4</a>
			<a href="index.php?num=5">5</a>
			</div>
		  </div>';
		}
		else if ($num == 3)
		{
			echo '<br><div class="center">
			<div class="pagination">
			<a href="index.php?num=1">1</a>
			<a href="index.php?num=2">2</a>
			<a href="index.php?num=3" class="active">3</a>
			<a href="index.php?num=4">4</a>
			<a href="index.php?num=5">5</a>
			</div>
		  </div>';
		}
		else if ($num == 4)
		{
			echo '<br><div class="center">
			<div class="pagination">
			<a href="index.php?num=1">1</a>
			<a href="index.php?num=2">2</a>
			<a href="index.php?num=3">3</a>
			<a href="index.php?num=4" class="active">4</a>
			<a href="index.php?num=5">5</a>
			</div>
		  </div>';
		}
		else
		{
			echo '<br><div class="center">
			<div class="pagination">
			<a href="index.php?num=1">1</a>
			<a href="index.php?num=2">2</a>
			<a href="index.php?num=3">3</a>
			<a href="index.php?num=4">4</a>
			<a href="index.php?num=5" class="active">5</a>
			</div>
		  </div>';
		}
	}
	
?>

</body>
<?php
    require "footer.php"
?>
</html>
 