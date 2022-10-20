<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>THACO AUTO </title>
    <?php include('Library/librarycss.php') ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG" onload="ClockApp()">
<?php include('Library/menu.php') ?>
<div id="bg-main">
</div>
<?php include('Library/navbar.php') ?>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script type="text/javascript">
    function Showalert()
    {
        alert('OK');
    }
</script>
</body>
</html>