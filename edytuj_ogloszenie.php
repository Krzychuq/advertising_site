<?php
session_start();
if(isset($_SESSION['dostep']) && $_SESSION['dostep'] >= 2){
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
<body style='display:grid;grid-template-rows:auto auto auto 1fr auto;grid-template-columns:100%;min-height:100vh;'>

<div class='panel_sign'>
    <p>PANEL</p>
</div>
<?php include_once('menu_nav.php') ?>
<!-- ////////////// KONTENT //////////////////////// -->
<div class='contener'>
<!-- /////////// LISTA OPCJI /////////////////////// -->
<section class='panel_lista_opcji'>

<!-- EDYTUJ OGLOSZENIE -->
<h2 style='text-align:center;'>Edytuj ogłoszenie</h2>
<?php
$pytanie = "SELECT nazwa, cena, ilosc, kategoria, nr_telefonu, opis, zdjecia FROM ogloszenia WHERE id_ogloszenia = ?";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$_POST['id']]);
$ogloszenie = $wykonaj -> fetch(PDO::FETCH_ASSOC);
    $nazwa = $ogloszenie['nazwa'];
    $cena = $ogloszenie['cena'];
    $ilosc = $ogloszenie['ilosc'];
    $kategoria = $ogloszenie['kategoria'];
    $nr_telefonu = $ogloszenie['nr_telefonu'];
    $opis = $ogloszenie['opis'];
    $zdjecia = $ogloszenie['zdjecia'];
?>
<form class='panel_dodaj_ogloszenie' action="edytuj_ogloszenie_conf.php" method='POST' enctype="multipart/form-data">
<!-- 1 -->
<div>
    <label for="nazwa">Nazwa</label>
    <input type="text" name='nazwa' placeholder='<?php echo $nazwa; ?>'>

</div>
<!-- 2 -->
<div>
    <label for="kategoria">Kategoria</label>
    <select name="kategoria" id="select_kategoria" >
<?php
    $pytanie = "SELECT * FROM kategoria_ogloszenia";
    $wykonaj = $conn -> query($pytanie) -> fetchAll();
    foreach($wykonaj as $kolumna){
        echo "<option value='$kolumna[id_kategorii]'>$kolumna[kategoria]</option>";
    }
?>  
</select>

</div>
<!-- 3 -->
<div>
    <label for="cena">Cena</label>
    <input type="number" min='0' name='cena' placeholder='<?php echo $cena; ?>'>
    
</div>
<!-- 4 -->
<div>
    <label for="ilosc">Ilość</label>
    <input type="number" min='1' max='999' name='ilosc' placeholder='<?php echo $ilosc; ?>'>
    
</div>
<!-- 5 -->
<div>
    <label for="nr_telefonu">Numer tel</label>
    <input type="number" minlength='9' maxlength='9' name='nr_telefonu' inputmode="numeric" placeholder='<?php echo $nr_telefonu; ?>'>
    
</div>
<!-- 6 -->
<div>
    <label for="zdjecia">Zdjecia</label>
    <input type="file" name="zdjecia[]" multiple>
    
</div>
<!-- 7 -->
<div>
    <label for="opis">Opis</label>
    <textarea type="text" name="opis" placeholder="Opis" style="resize: vertical; min-height:60px; max-height: 600px;" maxlength='1000'><?php echo $opis; ?></textarea>
</div>
<!-- 8 -->
<div>
    <input type="hidden" name='ogloszeniodawca' value='<?php echo $_SESSION['id_user']; ?>'>
    <input type="hidden" name='czas_dodania_ogloszenia' value='<?php echo date("Y/m/d H:i"); ?>'>
    <button type='submit' class='przycisk_form'>Dodaj</button>
</div>

</form>

</section>
<!-- /////////// END LISTA OPCJI /////////////////////// -->

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
