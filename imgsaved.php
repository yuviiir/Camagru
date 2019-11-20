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
	<div class="signin">
        Image uploaded.
    </div>
    <br>
    <a href="editor.php">
        <button class="button">
            Back To Editor
        </button>
    </a>
    <a href="index.php?num=1">
        <button class="button">
            Home
        </button>
    </a>
</body>
</html>