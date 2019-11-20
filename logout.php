<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Log Out</title>
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
        if($_SESSION['sess'] == true)
        {
            session_destroy();
            echo '<div class="signin">You have successfully logged out.</div>
            <br><a href="login.php"><button class="button">Log In</button></a>
            <a href="signup.php"><button class="button">Sign Up</button></a>';
        }
        else
        {
            echo '<div class="signin">You are not logged in.</div>
			<br><a href="login.php"><button class="button">Login</button></a>';
        }
    ?>
</body>
</html>