<?php
session_start();
include_once("laczenie_z_baza.php");
$nazwa = $_POST["nazwa"];
$kategoria = $_POST["kategoria"];
$cena = $_POST["cena"];
if(empty($cena)){ $cena = 0; }
$ilosc = $_POST["ilosc"];
$nr_telefonu = $_POST["nr_telefonu"];
$opis = $_POST["opis"];
$user = $_POST["ogloszeniodawca"];
$czas_dodania = $_POST["czas_dodania_ogloszenia"];

if(isset($_FILES['zdjecia']) || !empty($_FILES['zdjecia'])){
$liczba_zdjec = count($_FILES["zdjecia"]['name']);
$zdjecia_do_bazy = '';
for($i=0; $i < $liczba_zdjec; $i++){
    if(!empty($_FILES["zdjecia"]['name'][$i]) && isset($_FILES["zdjecia"]['name'][$i])){
        $rozszerzenie = mime_content_type($_FILES["zdjecia"]["tmp_name"][$i]);

    if($rozszerzenie == "image/png" || $rozszerzenie == "image/jpg" || $rozszerzenie == "image/jpeg" || $rozszerzenie == "image/webp"){

//POST
    if(is_uploaded_file($_FILES["zdjecia"]['tmp_name'][$i])){
//nowa nazwa z datą
        $zdjecie_bez_roz = explode(".",$_FILES["zdjecia"]['name'][$i]);
        $nowa_nazwa_zdjecia = date("Y-m-d-H-i-s") . "-$i" . '.' . $zdjecie_bez_roz[1];
        $sciezka = "ogloszenia/zdjecia_ogloszen/";
        $sciezka .= $nowa_nazwa_zdjecia;
        if($i == 0){ $zdjecia_do_bazy .= $nowa_nazwa_zdjecia . ","; }
        elseif($i == 1){ $zdjecia_do_bazy .= $nowa_nazwa_zdjecia; }
        else{ $zdjecia_do_bazy .= "," . $nowa_nazwa_zdjecia; }

//dodanie zdjecia do folderu
        move_uploaded_file($_FILES["zdjecia"]['tmp_name'][$i], $sciezka);
    }   
    }
    }
}
    
//generowanie strony
    $zmiana1 = str_replace("ą", "a", $nazwa);
    $zmiana2 = str_replace("ć", "c", $zmiana1);
    $zmiana3 = str_replace("ę", "e", $zmiana2);
    $zmiana4 = str_replace("ł", "l", $zmiana3);
    $zmiana5 = str_replace("ń", "n", $zmiana4);
    $zmiana6 = str_replace("ó", "o", $zmiana5);
    $zmiana7 = str_replace("ś", "s", $zmiana6);
    $zmiana8 = str_replace("ż", "z", $zmiana7);
    $zmiana9 = str_replace("ź", "z", $zmiana8);
    $zmiana10 = str_replace("Ą", "a", $zmiana9);
    $zmiana11 = str_replace("Ć", "c", $zmiana10);
    $zmiana12 = str_replace("Ę", "e", $zmiana11);
    $zmiana13 = str_replace("Ł", "l", $zmiana12);
    $zmiana14 = str_replace("Ń", "n", $zmiana13);
    $zmiana15 = str_replace("Ó", "o", $zmiana14);
    $zmiana16 = str_replace("Ś", "s", $zmiana15);
    $zmiana17 = str_replace("Ż", "z", $zmiana16);
    $zmiana18 = str_replace("Ź", "z", $zmiana17);
    $litery_male = strtolower($zmiana18);
    $str = str_replace(" ", "-", $litery_male);
    $litera = strtolower(chr(rand(65,91)));
    $generuj_indeks = rand(0,999999) . $litera;
    $strona = $str . "-" .$generuj_indeks. ".php";
//dodanie nowej strony ogloszenia   
    $nowastrona = 'ogloszenia/' . $strona;
    $nowa_strona_ogloszenia = fopen($nowastrona,"w");
    copy('ogloszenia/ogloszenie_podstawa.txt', $nowastrona);
    fclose($nowa_strona_ogloszenia);
// dodanie wpisu
$pytanie = "INSERT INTO ogloszenia(nazwa, cena, ilosc, kategoria, nr_telefonu, opis, przypisane_konto, zdjecia, link, czas_dodania)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$wykonaj = $conn -> prepare($pytanie);
$wykonaj -> execute([$nazwa, $cena, $ilosc, $kategoria, $nr_telefonu, $opis, $user, $zdjecia_do_bazy, $strona, $czas_dodania]);

$conn = null;
$_SESSION['success'] = 'Dodano ogłoszenie';
}  
else{
    $_SESSION['error'] = "Ni działa";
}      
header("location: panel.php");

?>