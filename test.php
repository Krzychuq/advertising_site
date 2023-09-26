<?php
session_start();
include_once('laczenie_z_baza.php');
if(isset($_SESSION['email'])) {
    $czas_aktualny = time();$_SESSION['expire'];
    
    if($czas_aktualny > $_SESSION['expire']) {
        session_unset();
        session_destroy();
    }
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
<?php include_once('menu_nav.php') ?>
<!-- ////////////// KONTENT //////////////////////// -->
<div class='contener'>
    <div>
        
    </div>
</div>


<?php 
if(isset($_SESSION['error'])){
    echo "<div class='error'>" . "&#10005 ". $_SESSION["error"] . "</div>";
    unset($_SESSION['error']);
    echo "<script src='blad.js'></script>";
}
if(isset($_SESSION['success'])){
    echo "<div class='success'>" . "&#10003 ". $_SESSION["success"] . "</div>";
    unset($_SESSION['success']);
    echo "<script src='powiadomienie.js'></script>";
}
$conn = null;
?>
<!-- ////////////// END KONTENT //////////////////////// -->  
    <?php include_once("footer.php") ?>
</body>
</html>
<script src='loading.js'></script>