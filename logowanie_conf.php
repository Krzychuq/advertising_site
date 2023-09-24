<?php
session_start();
include_once("laczenie_z_baza.php");
$email = $_POST['email'];
$pass = $_POST['pass'];
if(!empty($pass)){
$pytanieEmail = $conn->prepare('SELECT haslo FROM konta WHERE email like ?');
$pytanieEmail->execute([$email]);
$pass_baza = $pytanieEmail->fetch(PDO::FETCH_ASSOC);
$hash = $pass_baza['haslo'];

$czasZalogowania = date("Y-m-d H:i:s");
$userLog = $conn->prepare('UPDATE konta SET ostatnie_logowanie = ? WHERE email LIKE ?');
$userLog->execute([$czasZalogowania, $email]);
echo $hash;
$validation = password_verify($pass, $hash);

        if($validation == true){
                $_SESSION['email'] = $email;
                $_SESSION['koszyk'] = '';
                //identyfikacja i stopien konta
                $mail = $_SESSION['email'];
                $pyt_o_id = $conn->prepare("SELECT id_konta, dostep FROM konta WHERE email like ?");
                $pyt_o_id -> execute([$mail]);
                $wykonanie = $pyt_o_id->fetchAll();
                foreach ($wykonanie as $linia){
                    $id = $linia['id_konta'];
                    $dostep = $linia['dostep'];
                }       

                $conn = null;
                //czas uzytkownika
                $_SESSION['dostep'] = $dostep;
                $czas_sesji = time() + 86400;
                $czas_cookie = time() + (86400*7);
                $_SESSION['expire'] = $czas_sesji;
                $_SESSION['id_user'] = $id;
                setcookie( "uzytkownik", $_SESSION['email'], $czas_cookie,"/" );
                header("location: index.php");
        }
        else{
                $_SESSION['error'] = "Błedny email lub hasło!";
                header("location: logowanie.php");
        }
}
else{
        $_SESSION['error'] = "Wpisz hasło!";
        header("location: logowanie.php");
}

?>