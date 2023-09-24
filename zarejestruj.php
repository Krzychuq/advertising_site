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
<form id="formularz" class='zaloguj' action="zarejestruj_conf.php" method='POST'>
<!-- email -->
    <div class="divy">
      <label for="login"><img src="svg/email.svg" width="24px" height="auto" alt="Email: "></label>
      <input name='login' id="email" type="email" placeholder="Email" required>
    </div>
<!-- haslo -->
    <div class="divy">
      <label for="pass"><img src="svg/password.svg" width="24px" height="auto" alt="Hasło: "></label>
      <input name='pass' minlength="8" maxlength="32" id="haslo" type="password" placeholder="Hasło" required>
    </div>

<!-- powtorzone haslo -->
    <div class="divy">
      <label for="passp"><img src="svg/password.svg" width="24px" height="auto" alt="Powtórz hasło: "></label>
      <input name='passp' id="haslop" type="password" minlength="8" maxlength="32" placeholder="Powtórz hasło" required>
    </div>
<!-- pokaz haslo -->
    <label for="">Pokaż hasła</label>
    <input type="checkbox" class="pokaz_haslo" onclick="pokazhasla()" width="16" height="16"></input>

    <br style="margin-bottom: 1rem; margin-top: 0.3rem;">
<!-- wyslij -->
    <button id="przycisksub"  class="przycisk_zaloguj_zarejestruj" type="submit">Zarejestruj</button>

    <br style="margin-bottom: 1rem;">
<!-- wytyczne hasla -->
    <div id="alert_haslo"> 
      <span>&#x1F6C8</span>
      <span>Hasło musi zawierać: wielką literę, długość min 8 znaków i max 32 znaków i jeden znak specjalny !@#$%^&*</span> 
    </div>
    <br>

</form>
<?php 
// wyswietl blad
if(isset($_SESSION['error'])){
  echo "<div class='error'>" . "&#10005 ". $_SESSION["error"] . "</div>";
  unset($_SESSION['error']);
  echo "<script src='blad.js'></script>";
}
?>
</div>

    <?php include_once("footer.php") ?>
</body>
</html>
<script>
function pokazhasla() {
var haslo = document.getElementById("haslo");
var haslop = document.getElementById("haslop");

  //haslo pokaz
  if (haslo.type === "password") {
    haslo.type = "text";
  } 
  else {
    haslo.type = "password";
  }
  if (haslop.type === "password") {
    haslop.type = "text";
  } 
  else {
    haslop.type = "password";
  }
}
</script>
<script src="loading.js"></script>