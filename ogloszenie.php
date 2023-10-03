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
    <?php
$pytanie = "SELECT nazwa, cena, zdjecia, link, kategoria_ogloszenia.kategoria FROM ogloszenia INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria";
$wykonaj = $conn -> query($pytanie);
foreach($wykonaj as $linia){
    $zdjecia = explode(",", $linia["zdjecia"]);
    $link = 'ogloszenia/' . $linia["link"];
    echo "
    <div class='blok'>
    <a href='$link'>
    <p style='text-align:center; padding-top:2px; '>".ucfirst($linia['kategoria'])."</p>
    <div class='blok_zdjecie'>";

    if(!empty($zdjecia[1])){
        $zdjecie = "ogloszenia/zdjecia_ogloszen/" . $zdjecia[1];
        echo "<img src='$zdjecie' alt='produkt' width='180px' height='180px'>";
    }
    else{ 
        echo "<img src='ikony/brak_zdjecia.svg' alt='produkt' width='100px' height='100px'>";
    }
        

    echo "</div>
    <div class='blok_tekst'>
        <p>".ucfirst($linia['nazwa'])."</p>
        <p>$linia[cena] zł</p>
    </div>
    </a>
    </div>";
}



?>
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