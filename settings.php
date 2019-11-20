<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Settings</title>
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
        <div class="signin">
            Settings
        </div>
        <a href="changeusername.php">
            <button class="button">
                Change Username
            </button>
        </a>
        <a href="changeemail.php">
            <button class="button">
                Change Email
            </button>
        </a>
        <a href="changepassword.php">
            <button class="button">
                Change Password
            </button>
        </a>
        <a href="deleteacc.php">
            <button class="button">
                Delete Account
            </button>
        </a>
        <?php
            $notif = $_SESSION["notif"];
            if ($notif == 1)
            {
                echo
                '<a href="notif.php">
                <button class="button">
                    Turn Off Notifications
                </button>
                </a>';
            }
            else
            {
                echo
                '<a href="notif.php">
                <button class="button">
                    Turn On Notifications
                </button>
                </a>';
            }
        ?>
</body>
</html>