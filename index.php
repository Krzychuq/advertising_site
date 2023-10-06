<?php
session_start();
include_once('laczenie_z_baza.php');
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
    <div class='naglowek_list'>
        <p>Popularne</p>
    </div>
<div class='lista_blokow'>
<?php
$pytanie = "SELECT * FROM popularne";
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
<?php
if($_SESSION['dostep'] < 2){
    echo "<div class='zaloguj_zacheta'>
        <div>
            <img src='ikony/person_color.svg' width='120px' height='120px'>
        </div>
        <div>
            <p>Utworz konto, aby tworzyć ogłoszenia</p>
            <a href='zarejestruj.php'>Już teraz</a>
        </div>
    </div>";
}

?>
</div>

<?php include_once("footer.php"); ?>

</body>
</html>