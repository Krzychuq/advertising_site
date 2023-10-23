<?php
session_start();
if(isset($_SESSION['dostep']) && $_SESSION['dostep'] == 3){
    include_once('laczenie_z_baza.php');
    if(isset($_SESSION['email'])) {
        $czas_aktualny = time();$_SESSION['expire'];
        
        if($czas_aktualny > $_SESSION['expire']) {
            session_unset();
            session_destroy();
        }
    }
}
else{
    header('location: index.php');
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
<?php
if($_SESSION['dostep'] == 3){
echo "<div class='panel_sign'>
    <p>PANEL</p>
</div>";
}
?>
<?php include_once('menu_nav.php') ?>
<!-- ////////////// KONTENT //////////////////////// -->
<div class='contener'>

<!-- /////////// WYNIKI Z BAZY DANYCH /////////////// -->
<section class='panel_wyniki_baza'>

<h2 style='text-align:center; padding: 10px;'>Ogłoszenia archiwalne</h2>
    <table class='tabela'>
        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Kategoria</th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Ogłoszeniodawca</th>
            <th>Usuń</th>
        </tr>

<?php
    $pytanie_o_ogloszenia= "SELECT id_arch_ogloszenia, nazwa, cena, ilosc, kategoria_ogloszenia.kategoria, konta.email
    FROM archiwalne_ogloszenia
    INNER JOIN konta on konta.id_konta = archiwalne_ogloszenia.przypisane_konto
    INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = archiwalne_ogloszenia.kategoria
    ORDER BY id_arch_ogloszenia";

    $wykonaj = $conn -> query($pytanie_o_ogloszenia);
    $wyniki = $wykonaj -> fetchAll();


 foreach($wyniki as $wynik){
    $id = $wynik['id_arch_ogloszenia'];
    $nazwa = $wynik['nazwa'];
    $cena = $wynik['cena'];
    $ilosc = $wynik['ilosc'];
    $kategoria = $wynik['kategoria'];
    $przypisane_konto = $wynik['email'];
    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$nazwa</td>";
    echo "<td>$kategoria</td>";
    echo "<td>$cena</td>";
    echo "<td>$ilosc</td>";
    echo "<td>$przypisane_konto</td>";
//USUŃ OGŁOSZENIE
    echo "<td> 
    <form action='usun_ogloszenie_archive_conf.php' method='POST'>
    <input type='hidden' name='id' value='$id'>
    <button type='submit' class='tabela_przycisk'><img src='ikony/bin.svg' width='24px' height='24px'></button>
    </form>
    </td>
    </tr>"; 
 }
?>
    </table>  
</section>
<!-- /////////// END WYNIKI Z BAZY DANYCH /////////////// -->
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