<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Verify Account</title>
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
    require "config/database.php";
    $email = $_GET['email'];
    $hash = $_SESSION["hash"]; 
    $hashcheck = $_GET['hash'];
    if ($hash == $hashcheck)
    {
        try 
        {
            $conn = new PDO($db_host, $db_username, $db_password);
            $sql = "SELECT email FROM camagru.users WHERE email= :email";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':email', $email);
            $stm->execute();
            $result = $stm->rowCount();
            if ($result == 1)
            {
                $sql = "UPDATE users SET active=1 WHERE email = :email";
                $stm = $conn->prepare($sql);
                $stm->bindParam(':email', $email);
                $result = $stm->execute();
                session_destroy();
                echo '<div class="signin">You have successfully verified you account.</div>
                        <br><a href="login.php"><button class="button">Log In</button></a>';
            }
            else
            {	
                echo '<div class="signin">Error.</div>';
            }
        }
        catch (PDOException $e)
        {
            die("Error");	
        }
        $conn->close();
    }
    else
    {
        echo '<script>alert("You have already used this link.")
        location.replace("index.php")</script>';
    }
?>
</body>
</html>