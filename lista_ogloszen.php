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
    <div style='text-align:center; padding: 4px; color:#111111;'>
        <h2>Lista ogłoszeń</h2>
    </div>
    <div class='lista_blokow'>
<?php
$pytanie = "SELECT nazwa, cena, zdjecia, link, kategoria_ogloszenia.kategoria, czas_dodania
FROM ogloszenia 
INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria
ORDER BY czas_dodania DESC";
$wykonaj = $conn -> query($pytanie);
$liczba_ogloszen = 0;

foreach($wykonaj as $linia){
    $liczba_ogloszen +=1;
    $zdjecia = explode(",", $linia["zdjecia"]);
    $link = 'ogloszenia/' . $linia["link"];

    echo "
    <div class='blok'>
    <a href='$link'>
    <p class='blok_kategoria'>".ucfirst($linia['kategoria'])."</p>
    <div class='blok_zdjecie'>";

    if(!empty($zdjecia[0])){
        $zdjecie = "ogloszenia/zdjecia_ogloszen/" . $zdjecia[0];
        echo "<img src='$zdjecie' alt='produkt' width='180px' height='180px' style='border-radius: 3px;'>";
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