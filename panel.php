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
<body style='display:grid;grid-template-rows:auto auto auto 1fr auto;grid-template-columns:100%;min-height:100vh;'>

<div class='panel_sign'>
    <p>PANEL</p>
</div>
<?php include_once('menu_nav.php') ?>
<!-- ////////////// KONTENT //////////////////////// -->
<div class='contener'>
<!-- /////////// LISTA OPCJI /////////////////////// -->
<section class='panel_lista_opcji'>

<!-- DODAJ OGLOSZENIE -->
<h2 style='text-align:center;'>Dodaj ogłoszenie</h2>
<form class='panel_dodaj_ogloszenie' action="dodaj_ogloszenie_conf.php" method='POST' enctype="multipart/form-data">
<!-- 1 -->
<div>
    <label for="nazwa">Nazwa</label>
    <input type="text" name='nazwa' placeholder='...'>

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
    <input type="number" min='0' name='cena' placeholder='...'>
    
</div>
<!-- 4 -->
<div>
    <label for="ilosc">Ilość</label>
    <input type="number" min='1' max='999' name='ilosc' placeholder='1-999'>
    
</div>
<!-- 5 -->
<div>
    <label for="nr_telefonu">Numer tel</label>
    <input type="number" minlength='9' maxlength='9' name='nr_telefonu' inputmode="numeric" placeholder='np. 487315629'>
    
</div>
<!-- 6 -->
<div>
    <label for="zdjecia">Zdjecia</label>
    <input type="file" name="zdjecia[]" multiple>
    
</div>
<!-- 7 -->
<div>
    <label for="opis">Opis</label>
    <textarea type="text" name="opis" placeholder="Opis" style="resize: vertical; min-height:60px; max-height: 600px;" maxlength='1000'></textarea>
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

<!-- /////////// WYNIKI Z BAZY DANYCH /////////////// -->
<section class='panel_wyniki_baza'>
    <table class='tabela'>
        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Kategoria</th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Numer tel</th>
            <th>Ogłoszeniodawca</th>
            <th>Edytuj</th>
            <th>Usuń</th>
        </tr>

<?php
 $pytanie_o_ogloszenia= "SELECT id_ogloszenia, nazwa, cena, ilosc, kategoria_ogloszenia.kategoria, nr_telefonu, przypisane_konto, konta.email 
 FROM ogloszenia
 INNER JOIN konta on konta.id_konta = ogloszenia.przypisane_konto
 INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria";
 $wykonaj = $conn -> query($pytanie_o_ogloszenia) -> fetchAll();
 
 foreach($wykonaj as $wynik){
    $id = $wynik['id_ogloszenia'];
    $nazwa = $wynik['nazwa'];
    $cena = $wynik['cena'];
    $ilosc = $wynik['ilosc'];
    $kategoria = $wynik['kategoria'];
    $nr_telefonu = $wynik['nr_telefonu'];
    $przypisane_konto = $wynik['email'];
    $id_przypisane_konto = $wynik['przypisane_konto'];
    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$nazwa</td>";
    echo "<td>$kategoria</td>";
    echo "<td>$cena</td>";
    echo "<td>$ilosc</td>";
    echo "<td>$nr_telefonu</td>";
    echo "<td>$przypisane_konto</td>";
// EDYTUJ OGŁOSZENIE
    echo "<td>
    <form action='edytuj_ogloszenie.php' method='POST'>
    <input type='hidden' name='id' value='$id'>
    <button type='submit' class='tabela_przycisk'><img src='ikony/setting.svg' width='24px' height='24px'></button>
    </form>
    </td>";
//USUŃ OGŁOSZENIE
    echo "<td> 
    <form action='usun_ogloszenie_conf.php' method='POST'>
    <input type='hidden' name='id' value='$id'>
    <input type='hidden' name='nazwa' value='$nazwa'>
    <input type='hidden' name='cena' value='$cena'>
    <input type='hidden' name='ilosc' value='$ilosc'>
    <input type='hidden' name='kategoria' value='$kategoria'>
    <input type='hidden' name='nr_telefonu' value='$nr_telefonu'>
    <input type='hidden' name='przypisane_konto' value='$id_przypisane_konto'>
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