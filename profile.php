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
        $username = $_SESSION['username'];
		if($_SESSION['sess'] == true)
		{
            require "config/database.php";
            $uid = $_SESSION["uid"];
            $conn = new PDO($db_host, $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM pictures WHERE uid= :uid ORDER BY pid DESC";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':uid', $uid);
            $stm->execute();
            $arrpic = $stm->fetchAll();
            $i = 0;
			echo '<div class="signin">You are logged in as ';
            echo "$username";
            echo '.</div><br><a href="settings.php"><button class="button">Settings</button></a>
            <a href="logout.php"><button class="button">Log Out</button></a><div class="signin">Posts</div>';
            while($arrpic[$i])
            {
                $postarr = $arrpic[$i];
                $pid = $postarr[0];
                $pic = $postarr[2];
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
                echo '<br><div class="post"><div class="postimg">
				    <p>@'
                    .$_SESSION["username"].
                    '</p>
                    <img class="img" src="img/uploads/'.$pic.'">
                    <div>
                    <a href="likes.php?pic='.$pid.'"><button class="buttonpost">Likes</button></a>
                    <a href="comment.php?pic='.$pid.'"><button class="buttonpost">Comments</button></a>
                    <a href="deletepost.php?pic='.$pid.'"><button class="buttonpost">Delete</button></a><br>
                    </div>
                    <div>Likes: '.$likes.'</div>
                    <div>Comments: '.$comments.'</div>
                    </div>
                    </div><br>';
                    $i++;
            }
		}
		else
		{
			echo '<div class="signin">You need to log in or sign up.</div>
            <br><a href="login.php"><button class="button">Log In</button></a>
            <a href="signup.php"><button class="button">Sign Up</button></a>';
        }
    ?>
</body>
</html>