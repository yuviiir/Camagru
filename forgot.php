<?php
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
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
    <form action="#" method="post">
		<div class="container">
		  <h1>Forgot Password</h1>
		  <p>Please fill in this form to reset you password.</p>
		  <hr>
		  <label for="email"><b>Email</b></label>
		  <input type="email" placeholder="Enter Email" name="email" required>
          <div class="clearfix">
		  <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
			<button type="submit" name="submit" class="signupbtn">Reset</button>
		  </div>
		</div>
	</form>
    <?php
        require "config/database.php";
        if (isset($_POST['submit']))
        {
        $email = htmlspecialchars($_POST[email]);
        $hash = md5(date('YmdHis'));
        try 
        {
            $res = 0;
            $conn = new PDO($db_host, $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT active FROM camagru.users WHERE email= :email";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':email', $email);
            $stm->execute();
            $res = $stm->rowCount();

            if($res == 1)
            {	
                $to = $email;
                $subject = 'Swiftly | Reset Password'; 
                $message = '
                <br>
                <br>
                You have requested to reset password. If this was not you, please ignore this.<br>
                <br>
                ------------------------<br>
                <br>
                Please click this link to reset your password:<br>
                http://localhost:8080/camagru/resetpassword.php?email='.$email.'&hash='.$hash.'<br>
                <br>
                ';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";
                $headers .= "From: <no-reply@camagru.com>"."\r\n";
                if (mail($to, $subject, $message, $headers))
                {
                    $_SESSION["hash"] = $hash;
                    echo'<script>alert("Reset password email has been sent. Please click the link in the email.")
                    location.replace("login.php")</script>';
                }
                else
                {
                    echo '<script>alert("The email adress has not been registered. Please sign up.")
                    location.replace("signup.php")</script>';
                }           
            }
            else
                {
                    echo '<script>alert("The email adress has not been registered. Please sign up.")
                    location.replace("signup.php")</script>';
                } 
        }
        catch (PDOException $e)
        {
            echo '<script>alert("The email adress has not been registered. Please sign up.")
            signup.replace("login.php")</script>';
        }
        $conn->close();
    }
    ?>
</body>
</html>