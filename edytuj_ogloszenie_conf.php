<?php
session_start();
include_once('laczenie_z_baza.php');

$id = $_POST['id'];
$nazwa = $_POST["nazwa"];
$kategoria = $_POST["kategoria"];
$cena = $_POST["cena"];
$ilosc = $_POST["ilosc"];
$nr_telefonu = $_POST["nr_telefonu"];

$pytanie = "UPDATE ogloszenia SET =";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$id]);

$conn = null;
$_SESSION['success'] = "Usunieto ogłoszenie nr $id";
header('location: panel.php');
?>