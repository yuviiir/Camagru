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
        $sql = "SELECT * FROM comments WHERE pid= :pid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':pid', $pid);
        $stm->execute();
        $arr = $stm->fetchAll();
        $i = 0;
        echo '<div class="signin">Comments</div><br>';
        while($arr[$i])
        {
            $uid = $arr[$i]['uid']; 
            $comm = $arr[$i]['comment'];
            $cid = $arr[$i]['cid'];
            $sql = "SELECT username FROM users WHERE uid= :uid";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':uid', $uid);
            $stm->execute();
            $user = $stm->fetchColumn();
            $sql = "SELECT uid FROM comments WHERE pid= :pid";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':pid', $pid);
            $stm->execute();
            $commuid = $stm->fetchColumn();
            $sql = "SELECT uid FROM pictures WHERE pid= :pid";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':pid', $pid);
            $stm->execute();
            $uid = $stm->fetchColumn();
            if (($uid == $_SESSION['uid']) || ($commuid == $_SESSION['uid']))
                echo '<div class="likes"><a href="search.php?search='.$user.'">@'.$user.':</a> '.$comm.'<a href="deletecomm.php?pic='.$pid.'&cid='.$cid.'"><button class="buttondelete">Delete</button></a></div>';
            else
                echo '<div class="likes"><a href="search.php?search='.$user.'">@'.$user.':</a> '.$comm.'</div>';
            $i++;
        }
        if ($i == 0)
        {
            echo '<div class="likes">This post has no comments.</div>';
        }
        $sql = "SELECT uid FROM pictures WHERE pid= :pid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':pid', $pid);
        $stm->execute();
        $uid = $stm->fetchColumn();
        $sql = "SELECT email FROM users WHERE uid= :uid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':uid', $uid);
        $stm->execute();
        $email = $stm->fetchColumn();
        $sql = "SELECT notif FROM users WHERE uid= :uid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':uid', $uid);
        $stm->execute();
        $notif = $stm->fetchColumn();
        ?>
        <form action="#" method="post">
		<div class="container">
		  <p>New Comment</p>
		  <hr>
		  <input type="text" placeholder="Comment" name="comment" required>
		  <div class="clearfix">
		  <a href="profile.php"><button type="button" class="cancelbtn">Cancel</button></a>
          <button type="submit" name="submit" class="signupbtn">Comment</button>
		  </div>
		</div>
      </form>
      <?php
      if (isset($_POST['submit']))
      {   
        
        $comm = htmlspecialchars($_POST['comment']);    
        $uid = $_SESSION["uid"];
        $sql = "INSERT INTO camagru.comments (pid, uid, comment)
		VALUES (:pid, :uid, :comm)";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':pid', $pid);
        $stm->bindParam(':uid', $uid);
        $stm->bindParam(':comm', $comm);
        $stm->execute();
        
        if ($notif)
        {
            $to = $email;
            $subject = 'Swiftly | New Comment'; 
            $message = '
            <br>
            You have recieved a new comment!<br>
            Log in to view it.<br>
            <br>
            ';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";
            $headers .= "From: <no-reply@camagru.com>"."\r\n";
            mail($to, $subject, $message, $headers);
        }
        header("Location: comment.php?pic=".$pid);
      }
    ?>