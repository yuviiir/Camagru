<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
	require "header.php";
?>
<script>
	elem = document.getElementById('editor');
	elem.classList.add('active');
</script>
    <?php
		if($_SESSION['sess'] == false)
		{
			echo '<div class="signin">Please log in or sign up to continue.</div>
            <br><a href="login.php"><button class="button">Log In</button></a>
            <a href="signup.php"><button class="button">Sign Up</button></a>';
		}
        else
        {
			echo '<div class="webcam">
        <div>
        <video id="video"></video>
        <a id="capture" class="capturebutt">
            Take photo
        </a>
        </div>
        <div class="cap">
        <canvas id="canvas">
        </canvas>
        <a id="upload" class="capturebutt">
            Upload
        </a>
        </div>
   
</div>
    <div class="stickers">
    <div>
        <a id="1" class="capturebutt1"><img id="s1" class="sticker" src="img/stickers/alien.png" onclick="selectsticker(\'s1\')"></a>
    </div>
    <div>
       <a id="2" class="capturebutt1"><img id="s2" class="sticker" src="img/stickers/shrek.png" onclick="selectsticker(\'s2\')"></a>
    </div>
    <div>
      <a id="3" class="capturebutt1"><img id="s3" class="sticker" src="img/stickers/hearts.png" onclick="selectsticker(\'s3\')"></a>
    </div>
    </div>
    <form class="uploadform" enctype="multipart/form-data" action="upload.php" method="POST">
            <input class="upload" type="file" name="file" accept="image/*">
            <div class="cap">
            </div>
            <button class="upload" type="submit">Upload file</button>
    </form>
   <script src="webc.js"></script>';
        }
        ?>
</body>
<footer>
<?php
    require "footer.php"
?>
</footer>
</html>
 
