<?php
   session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<?php
    if ($_SESSION['sess'] == true)
    {
        $username = $_SESSION["username"];
        echo '<footer>
            <hr>
            <div class="foot">Logged in as: ';
        echo "$username";
        echo '.</div>
            <a href="logout.php"><button class="buttfoot">Log Out</button></a>	
            </footer>';
    }
?>
</html>