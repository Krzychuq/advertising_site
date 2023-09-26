<?php
session_start();
include_once('laczenie_z_baza.php');

$id = $_POST['id'];

if(!empty($_POST["nazwa"]) && isset($_POST["nazwa"])){
    $nazwa = $_POST["nazwa"];
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
    $str = str_replace(" ", "-", $zmiana18);

    $pyt = $conn -> prepare("SELECT link FROM ogloszenia WHERE id_ogloszenia = ?");
    $pyt -> execute([$id]);
    $link = $pyt -> fetch();
    $stara_strona = "ogloszenia/" . $link["link"];
    $litera = strtolower(chr(rand(65,91)));
    $generuj_indeks = rand(0,999999) . $litera;
    $strona = $str . "-" .$generuj_indeks. ".php";
    $nowa_strona_nazwa = "ogloszenia/" . $strona;

    rename($stara_strona, $nowa_strona_nazwa);

    $pytanie = "UPDATE ogloszenia SET nazwa = ?, link = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$str, $strona, $id]);
}

if(!empty($_POST["cena"]) && isset($_POST["cena"])){
    $cena = $_POST["cena"];
    $pytanie = "UPDATE ogloszenia SET cena = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$cena, $id]);
}

if(!empty($_POST["kategoria"]) && isset($_POST["kategoria"])){
    $kategoria = $_POST["kategoria"];
    $pytanie = "UPDATE ogloszenia SET kategoria = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$kategoria, $id]);
}

if(!empty($_POST["ilosc"]) && isset($_POST["ilosc"])){
    $ilosc = $_POST["ilosc"];
    $pytanie = "UPDATE ogloszenia SET ilosc = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$ilosc, $id]);
}

if(!empty($_POST["opis"]) && isset($_POST["opis"])){
    $opis = $_POST["opis"];
    $pytanie = "UPDATE ogloszenia SET opis = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$opis, $id]);
}
// ZROB USUWANIE I DODAWANIE ZDJEC GL HF GG
// if(isset($_FILES['zdjecia']) && !empty($_FILES['zdjecia'])){
//     $liczba_zdjec = count($_FILES["zdjecia"]['name']);
//     $zdjecia_do_bazy = '';
    
//     for($i=0; $i < $liczba_zdjec; $i++){
//         if(!empty($_FILES["zdjecia"]['name'][$i]) && isset($_FILES["zdjecia"]['name'][$i])){
//             $rozszerzenie = mime_content_type($_FILES["zdjecia"]["tmp_name"][$i]);
    
//         if($rozszerzenie == "image/png" || $rozszerzenie == "image/jpg" || $rozszerzenie == "image/jpeg" || $rozszerzenie == "image/webp"){
    
//     //POST
//         if(is_uploaded_file($_FILES["zdjecia"]['tmp_name'][$i])){
//     //nowa nazwa z datą
//             $zdjecie_bez_roz = explode(".",$_FILES["zdjecia"]['name'][$i]);
//             $nowa_nazwa_zdjecia = date("Y-m-d-H-i-s") . "-$i" . '.' . $zdjecie_bez_roz[1];
//             $sciezka = "ogloszenia/zdjecia_ogloszen/";
//             $sciezka .= $nowa_nazwa_zdjecia;
//             $zdjecia_do_bazy .= "," . $nowa_nazwa_zdjecia;
//     //dodanie zdjecia do folderu
//             move_uploaded_file($_FILES["zdjecia"]['tmp_name'][$i], $sciezka);
//         }   
//         }
//         }
//     }
    
// }

if(!empty($_POST["nr_telefonu"]) && isset($_POST["nr_telefonu"])){
    $nr_telefonu = $_POST["nr_telefonu"];
    $pytanie = "UPDATE ogloszenia SET nr_telefonu = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$nr_telefonu, $id]);
}

if(!empty($_POST["czas_edycji_ogloszenia"]) && isset($_POST["czas_edycji_ogloszenia"])){
    $czas_edycji_ogloszenia = $_POST["czas_edycji_ogloszenia"];
    $pytanie = "UPDATE ogloszenia SET czas_dodania = ? WHERE id_ogloszenia = ?";
    $wykonaj = $conn -> prepare($pytanie);
    $wykonaj -> execute([$czas_edycji_ogloszenia, $id]);
}


$conn = null;
$_SESSION['success'] = "Zmieniono ogłoszenie nr $id";
header('location: panel.php');
?>