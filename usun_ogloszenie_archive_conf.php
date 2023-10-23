<?php
session_start();
include_once('laczenie_z_baza.php');

$id = $_POST['id'];

$pytanie = "DELETE FROM archiwalne_ogloszenia WHERE id_arch_ogloszenia = ?";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$id]);

$conn = null;
$_SESSION['success'] = "Usunieto ogłoszenie nr $id";
header('location: panel_archive.php');
?>