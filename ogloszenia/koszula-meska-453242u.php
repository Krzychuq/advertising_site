<?php
session_start();
include_once('../laczenie_z_baza.php');
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
    <link rel="stylesheet" href="../style.css">
    <title>Portal ogłoszeniowy</title>
</head>
<body>
<?php include_once('../menu_nav_ogloszenie.php') ?>
<!-- ////////////// KONTENT //////////////////////// -->
<div class='contener'>

<div class='produkt_box'>

<?php
$url = $_SERVER['REQUEST_URI'];
$url = parse_url($url);
$cut_url = explode("/",$url['path']);
$url = end($cut_url);
$pytanie = "SELECT id_ogloszenia, nazwa, cena, ilosc, nr_telefonu, opis, konta.imie, konta.data_rejestracji, zdjecia, kategoria_ogloszenia.kategoria, czas_dodania 
FROM ogloszenia 
INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria
INNER JOIN konta on konta.id_konta = ogloszenia.przypisane_konto
WHERE link = ?";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$url]);
$produkt_dane = $wykonaj -> fetch(PDO::FETCH_ASSOC);
$zdjecia = explode(",", $produkt_dane["zdjecia"]);

    echo "<div class='produkt_ident'>
        <span>$produkt_dane[id_ogloszenia]</span>
        <span>Dodano: $produkt_dane[czas_dodania]</span>
    </div>";

    echo "<div class='produkt_showcase'>";

    if(!empty($zdjecia[0])){
        
        $showcase = array();
        foreach($zdjecia as $zdjecie){
            $dodane_z = "zdjecia_ogloszen/".$zdjecie;
            array_push($showcase, $dodane_z);
        }
        echo "<button onclick='zdjecie_minus()'> < </button>";
        echo "<img id='zdjecie_produktu' src='$showcase[0]' alt='produkt'>";
        echo "<button onclick='zdjecie_plus()'> > </button>";
    }
    else{ 
        echo "<img src='../ikony/brak_zdjecia.svg' alt='produkt' width='90%' height='auto'>";
    }
    
    
    echo "</div>";
?> 

    <div class='produkt_info'>
        <p><?php echo ucfirst($produkt_dane["nazwa"]); ?></p>
        <span>Ilość: <?php echo $produkt_dane["ilosc"]; ?>szt</span>
        <span>Cena: <?php echo $produkt_dane["cena"]; ?>zł</span>
    </div>
    
    <div class='produkt_opis'>
        <h3>Opis</h3>
        <span><?php echo ucfirst($produkt_dane["opis"]); ?></span>
    </div>
    <div class='produkt_grupaOL'>
        <div class='produkt_ogloszeniodawca'>
            <div>
                <img src="../ikony/person.svg" alt="personIcon">
            </div>
            <div>
                <p style='font-weight: bold;'><?php echo ucfirst($produkt_dane["imie"]); ?></p>
                <p>
                <?php 
                $rok = explode('-', $produkt_dane["data_rejestracji"]);
                echo "Z nami od " . $rok[0] . " roku"; 
                ?>
                </p>
            </div>

        </div>
        <div class='produkt_lokalizacja'>
            <img src="https://media1.giphy.com/media/wFmAaA333ZXOwTA7d8/giphy.gif?cid=ecf05e47lzv29uino41d549ae89ssj9fqt4dj6v1r28l1r8r&ep=v1_gifs_search&rid=giphy.gif&ct=g" alt="mapa_google" width='150px' heigth='auto'>
        </div>
    </div>

    
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
    <?php include_once("../footer.php") ?>
</body>
</html>
<script>
zdjecia = (<?php echo json_encode($showcase) ?>);
</script>
<script src="../showcase_p.js"></script>