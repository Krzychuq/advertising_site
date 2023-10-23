<?php
session_start();
if(isset($_SESSION['dostep']) && $_SESSION['dostep'] == 3 || $_SESSION['dostep'] == 2){
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
<!-- /////////// LISTA OPCJI /////////////////////// -->
<?php
if($_SESSION['dostep'] == 3){
echo "<a style=' font-size: 1.1rem; text-decoration: none; color: #d4562f; text-align:center; border-bottom: 1px solid #171717;' href='panel_archive.php'>Ogłoszenia archiwalne</a><br>";
}
?>
<section class='panel_lista_opcji'>

<!-- DODAJ OGLOSZENIE -->
<h2 style='text-align:center;'>Dodaj ogłoszenie</h2>
<form class='panel_dodaj_ogloszenie' action='dodaj_ogloszenie_conf.php' method='POST' enctype='multipart/form-data'>
<!-- 1 -->
<div>
    <label for='nazwa'>Nazwa</label>
    <input type='text' name='nazwa' placeholder='...' required>

</div>
<!-- 2 -->
<div>
    <label for='kategoria'>Kategoria</label>
    <select name='kategoria' id='select_kategoria' required>
<?php
    $pytanie = "SELECT * FROM kategoria_ogloszenia";
    $wykonaj = $conn -> query($pytanie) -> fetchAll();
    foreach($wykonaj as $kolumna){
        echo "<option value='$kolumna[id_kategorii]'>$kolumna[kategoria]</option>";
    }
?>
</select>

</div>
<!-- 3  -->
<div>
    <label for='cena'>Cena</label>
    <input type='number' min='0' step="0.01" name='cena' placeholder='...'>
    
</div>
<!-- 4  -->
<div>
    <label for='ilosc'>Ilość</label>
    <input type='number' min='1' max='999' name='ilosc' placeholder='1-999' required>
    
</div>
<!-- 5  -->
<div>
    <label for='nr_telefonu'>Numer tel</label>
    <input type='number' minlength='9' maxlength='9' name='nr_telefonu' inputmode='numeric' placeholder='np. 487315629' onkeyup='weryfikuj_dlugosc_numeru(this)' required>
    
</div>
<!-- 6  -->
<div>
    <label for='zdjecia'>Zdjecia</label>
    <input type='file' name='zdjecia[]' multiple>
    
</div>
<!-- 7  -->
<div>
    <label for='opis'>Opis</label>
    <textarea type='text' name='opis' placeholder='Opis' style='resize: vertical; min-height:60px; max-height: 600px;' maxlength='1000'></textarea>
</div>
<!-- 8  -->
<div>
    <input type='hidden' name='ogloszeniodawca' value='<?php echo $_SESSION['id_user']; ?>'>
    <input type='hidden' name='czas_dodania_ogloszenia' value='<?php echo date("Y/m/d H:i"); ?>'>
    <button type='submit' class='przycisk_form'>Dodaj</button>
</div>

</form>

</section>

<!-- /////////// END LISTA OPCJI /////////////////////// -->

<!-- /////////// WYNIKI Z BAZY DANYCH /////////////// -->
<section class='panel_wyniki_baza'>
    
    <?php
    if($_SESSION['dostep'] == 2){
        $pytanie= "SELECT LiczbaOgloszen(?) as 'LiczbaOgloszen'";
        $wykonaj = $conn -> prepare($pytanie);
        $wykonaj -> execute([$_SESSION["id_user"]]);
        $wyniki = $wykonaj -> fetch(PDO::FETCH_ASSOC);
        echo "<h2 style='text-align:center; padding: 10px;'>Twoje oferty" . " " . "(".$wyniki['LiczbaOgloszen'].")</h2>";
    }
    else{
        echo "<h2 style='text-align:center; padding: 10px;'>Ogłoszenia</h2>";
    }
    ?>
    <table class='tabela'>
        <tr>
            <?php
            if($_SESSION['dostep'] == 3){
                echo "<th>ID</th>";
            }
            ?>
            <th>Nazwa</th>
            <th>Kategoria</th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Numer tel</th>
            <?php
            if($_SESSION['dostep'] == 3){
                echo "<th>Ogłoszeniodawca</th>";
            }
            ?>
            <th>Edytuj</th>
            <th>Usuń</th>
        </tr>

<?php
if($_SESSION['dostep'] == 3){
    $pytanie_o_ogloszenia= "SELECT id_ogloszenia, nazwa, cena, ilosc, kategoria_ogloszenia.kategoria, ogloszenia.kategoria as 'id_kategoria', nr_telefonu, przypisane_konto, konta.email, link 
    FROM ogloszenia
    INNER JOIN konta on konta.id_konta = ogloszenia.przypisane_konto
    INNER JOIN kategoria_ogloszenia on kategoria_ogloszenia.id_kategorii = ogloszenia.kategoria
    ORDER BY id_ogloszenia";

    $wykonaj = $conn -> query($pytanie_o_ogloszenia);
    $wyniki = $wykonaj -> fetchAll();
}
else{
    $pytanie_o_ogloszenia= "CALL WyswietlOgloszeniaUzytkownika(?);";

    $wykonaj = $conn -> prepare($pytanie_o_ogloszenia);
    $id_konta = $_SESSION["id_user"];
    $wykonaj -> execute([$id_konta]);
    $wyniki = $wykonaj -> fetchAll();
}


 
 foreach($wyniki as $wynik){
    $id = $wynik['id_ogloszenia'];
    $nazwa = $wynik['nazwa'];
    $cena = $wynik['cena'];
    $ilosc = $wynik['ilosc'];
    $id_kategoria = $wynik['id_kategoria'];
    $kategoria = $wynik['kategoria'];
    $nr_telefonu = $wynik['nr_telefonu'];
    if($_SESSION['dostep'] == 3){
        $przypisane_konto = $wynik['email'];
    }
    $id_przypisane_konto = $wynik['przypisane_konto'];
    $link = $wynik['link'];
    echo "<tr>";
    if($_SESSION['dostep'] == 3){
    echo "<td>$id</td>";
    }
    echo "<td><a href='ogloszenia/$link'>$nazwa</a></td>";
    echo "<td>$kategoria</td>";
    echo "<td>$cena</td>";
    echo "<td>$ilosc</td>";
    echo "<td>$nr_telefonu</td>";
    if($_SESSION['dostep'] == 3){
    echo "<td>$przypisane_konto</td>";
    }
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
    <input type='hidden' name='kategoria' value='$id_kategoria'>
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
<script>
function weryfikuj_dlugosc_numeru(inp){
    if(inp.value.length == 9){
        inp.style.border = "1px solid #68cd15";
    }
    else if(inp.value.length == 0){
        inp.style.border = "1px solid grey";
    }
    else{
        inp.style.border = "1px solid #cd1815";
    }
    inp.style.borderRadius = "2px";
}
</script>
<script src='loading.js'></script>