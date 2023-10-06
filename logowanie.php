<?php
session_start();
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
<?php include_once('menu_nav.php') ?>
<div class='contener'>
    <form class='zaloguj' action="logowanie_conf.php" method='POST'>
        <div class="rejestracja_input">
            <label for="email"><img src="ikony/email.svg" width="24px" height="auto" alt="Email: "></label>
            <input name='email' type="email" placeholder="Email">
        </div>
        
        <div class="rejestracja_input">
            <label for="pass"><img src="ikony/password.svg" width="24px" height="auto" alt="Hasło: "></label>
            <input name='pass' type="password" placeholder="Hasło" id='haslo'>
        </div>
        <!-- pokaz haslo -->
        <label for="show">Pokaż hasło</label>
        <input name='show' type="checkbox" class="pokaz_haslo" onclick="pokazhasla()" width="16" height="16"></input><br>
        
        
        <button type='submit' class="przycisk_zaloguj_zarejestruj">Zaloguj się</button><br>
        <div class="rejestracja">
        <p>Nie masz konta? <a style='color:#eb9e11; text-decoration: 1px underline dashed;' href="zarejestruj.php"> Zarejestruj się</a></p>
        </div>
    </form>
    

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
?>
</div>

    <?php include_once("footer.php") ?>
</body>
</html>
<script>
function pokazhasla() {
var haslo = document.getElementById("haslo");

  //haslo pokaz
  if (haslo.type === "password") {
    haslo.type = "text";
  } 
  else {
    haslo.type = "password";
  }
}
</script>
<script src="loading.js"></script>