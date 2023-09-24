<?php
session_start();
include_once("laczenie_z_baza.php");
$login = $_POST['login'];
$pass = $_POST['pass'];
$powtorzone_pass = $_POST['passp'];
$password = password_hash($pass, PASSWORD_ARGON2I);
if( isset($login) && !empty($login) && isset($pass) && !empty($pass) ){
    unset($_SESSION['email']);
    $patern = "/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*]*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,32}$/";
    $weryfikacja_hasla = preg_match($patern, $pass);
    
    if( $pass == $powtorzone_pass){
        if($weryfikacja_hasla == TRUE){
        $l="";
        $data = date("Y-m-d H:i:s");
        $czas_rejestracji = $data;
        $sprawdzenie = $conn -> prepare('SELECT email from konta where email like ?');
        $sprawdzenie -> execute([$login]);
        $wykonaj_sprawdzenie = $sprawdzenie -> fetchColumn();
        if($wykonaj_sprawdzenie){ 
                $l = $wykonaj_sprawdzenie;
        }   
         if($login == $l){
            $_SESSION['wiadomosc_loginu'] = "Email jest zajety";
             header("location: logowanie.php");
             $conn = null;
         }
    
         else{             
            $dostep = 1;
            $zapytanie1 = $conn -> prepare("INSERT INTO konta (email, haslo, data_rejestracji, dostep) VALUES(?, ?, ?, ?)");
            $zapytanie1 -> execute([$login, $password, $czas_rejestracji, $dostep]);
        
             if ($zapytanie1 == TRUE) {
                 echo $login." ". $password. " ". $czas_rejestracji;
                 $_SESSION['success'] = "Zarejestrowano";
             } 
             else {
                $_SESSION['error'] =  "Błąd dodania konta";
                header("location: rejestracja.php");
             }
            
             $conn = null;
             header("location: logowanie.php");
         }
        }
        else{
            $_SESSION['error'] = "Hasło nie zgadza się z wytycznymi!";
            header("location: rejestracja.php");
        }
        
    }

    else{
        $_SESSION['error'] = 'Hasła nie są takie same!';
        header("location: rejestracja.php");
    }
    
}

else{
    $_SESSION['error'] = 'Wpisz email i hasło!';
    header("location: rejestracja.php");
}
?>