<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
	require "header.php";
?>
<script>
	elem = document.getElementById('search');
	elem.classList.add('active');
</script>
      <?php
      if (isset($_POST['submit']))
      {   
            require "config/database.php";
            $username = $_POST['search'];
            $conn = new PDO($db_host, $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT uid FROM users WHERE username= :username";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':username', $username);
            $stm->execute();
            $uid = $stm->fetchColumn();
            $sql = "SELECT * FROM pictures WHERE uid= :uid ORDER BY pid DESC";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':uid', $uid);
            $stm->execute();
            $arrpic = $stm->fetchAll();
            $count = $stm->rowCount();
            $i = 0;
            if ($count == 0)
            {
                echo '<div class="signin">User @'.$username.' does not exist. Try again.</div>';
            }
            else
            {
                echo '<div class="signin">@'.$username.'</div>';
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
                            <p>@'
                            .$username.
                            '</p>
                            <img class="img" src="img/uploads/'.$pic.'">
                            <a href="unlike.php?pic='.$pid.'"><button class="buttonpost">Unlike</button></a>
                            <a href="comment.php?pic='.$pid.'"><button class="buttonpost">Comment</button></a><br>
                            <div>Likes: '.$likes.'</div>
                            <div>Comments: '.$comments.'</div>
                            </div>
                            </div><br>';
                        }
                        else
                        {
                            echo '<br><div class="post"><div class="postimg">
                            <p>@'
                            .$username.
                            '</p>
                            <img class="img" src="img/uploads/'.$pic.'">
                            <a href="like.php?pic='.$pid.'"><button class="buttonpost">Like</button></a>
                            <a href="comment.php?pic='.$pid.'"><button class="buttonpost">Comment</button></a><br>
                            <div>Likes: '.$likes.'</div>
                            <div>Comments: '.$comments.'</div>
                            </div>
                            </div><br>';
                        }
                    }
                    else
                    {
                        echo '<br><div class="post"><div class="postimg">
                        <p>@'
                        .$username.
                        '</p>
                        <img class="img" src="img/uploads/'.$pic.'">
                        <div><br>Likes: '.$likes.'</div>
                        <div>Comments: '.$comments.'</div>
                        </div>
                        </div><br>';
                    }
                }
            }
        }
        else if ($_GET['search'])
        {
            require "config/database.php";
            $username = $_GET['search'];
            $conn = new PDO($db_host, $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT uid FROM users WHERE username= :username";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':username', $username);
            $stm->execute();
            $uid = $stm->fetchColumn();
            $sql = "SELECT * FROM pictures WHERE uid= :uid ORDER BY pid DESC";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':uid', $uid);
            $stm->execute();
            $arrpic = $stm->fetchAll();
            $count = $stm->rowCount();
            $i = 0;
            if ($count == 0)
            {
                echo '<div class="signin">User @'.$username.' does not exist. Try again.</div>';
            }
            else
            {
                echo '<div class="signin">@'.$username.'</div>';
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
                            <p>@'
                            .$username.
                            '</p>
                            <img class="img" src="img/uploads/'.$pic.'">
                            <a href="unlike.php?pic='.$pid.'"><button class="buttonpost">Unlike</button></a>
                            <a href="comment.php?pic='.$pid.'"><button class="buttonpost">Comment</button></a><br>
                            <div>Likes: '.$likes.'</div>
                            <div>Comments: '.$comments.'</div>
                            </div>
                            </div><br>';
                        }
                        else
                        {
                            echo '<br><div class="post"><div class="postimg">
                            <p>@'
                            .$username.
                            '</p>
                            <img class="img" src="img/uploads/'.$pic.'">
                            <a href="like.php?pic='.$pid.'"><button class="buttonpost">Like</button></a>
                            <a href="comment.php?pic='.$pid.'"><button class="buttonpost">Comment</button></a><br>
                            <div>Likes: '.$likes.'</div>
                            <div>Comments: '.$comments.'</div>
                            </div>
                            </div><br>';
                        }
                    }
                    else
                    {
                        echo '<br><div class="post"><div class="postimg">
                        <p>@'
                        .$username.
                        '</p>
                        <img class="img" src="img/uploads/'.$pic.'">
                        <div><br>Likes: '.$likes.'</div>
                        <div>Comments: '.$comments.'</div>
                        </div>
                        </div><br>';
                    }
                }
            }  
        }
        else
            echo '        <form action="#" method="post">
            <div class="container">
              <h1>Search</h1>
              <hr>
              <input type="text" placeholder="Enter Username" name="search" required>
              <div class="clearfix">
              <a href="profile.php"><button type="button" class="cancelbtn">Cancel</button></a>
              <button type="submit" name="submit" class="signupbtn">Search</button>
              </div>
            </div>
          </form>';
?>
</body>

<?php
    require "footer.php"
?>
</html>