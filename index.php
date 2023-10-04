<?php
session_start();
if(isset($_SESSION['email'])) {
    $czas_aktualny = time();
    
    if ($czas_aktualny > $_SESSION['expire']) {
        session_unset();
        session_destroy();
    }
}
else{
    $_SESSION['dostep'] = 1;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Portal ogłoszeniowy</title>
</head>
<body>
    <?php include_once('menu_nav.php');?>
    <div class='contener'>

    </div>
    
    <?php include_once("footer.php"); ?>
</body>
</html>