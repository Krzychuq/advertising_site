<?php
session_start();
include_once('laczenie_z_baza.php');

$id = $_POST['id'];
$nazwa = $_POST["nazwa"];
$kategoria = $_POST["kategoria"];
$cena = $_POST["cena"];
$ilosc = $_POST["ilosc"];
$przypisane_konto = $_POST["przypisane_konto"];

$pytanie = "SELECT zdjecia, link FROM ogloszenia WHERE id_ogloszenia = ?";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$id]);
$wyniki = $wykonaj -> fetch(PDO::FETCH_ASSOC);

$zdjecia = explode(",",$wyniki['zdjecia']);
foreach($zdjecia as $zdjecie){
    unlink("ogloszenia/zdjecia_ogloszen/".$zdjecie);
} // usuniecie zdjeć z ogloszenia
$strona = "ogloszenia/".$wyniki['link'];
unlink($strona); // usuniecie strony ogloszenia

$pytanie = "INSERT INTO archiwalne_ogloszenia(nazwa, cena, ilosc, kategoria, przypisane_konto) VALUES(?,?,?,?,?)";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$nazwa, $cena, $ilosc, $kategoria, $przypisane_konto]);

$pytanie = "DELETE FROM ogloszenia WHERE id_ogloszenia = ?";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$id]);

$conn = null;
$_SESSION['success'] = "Usunieto ogłoszenie nr $id";
header('location: panel.php');
?>