<?php
$hostname='localhost';
$username='root';
$pass='';
$bazaD ='advertising_site';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$bazaD", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } 
  catch(PDOException $error) {
    echo "Połączenie sie nie powiodło: " . $error->getMessage();
  }

?>