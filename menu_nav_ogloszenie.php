<?php


?>
<link rel="icon" type="image/x-icon" href="../favicon.ico">
<div class='menu_nav'>

    <div class='menu_block'>
        <a href="../index.php"><img src="../ikony/logo.svg" alt="Portal" width=46px height=46px></a>
    </div>

    <div class='menu_block'>
        <a href="../lista_ogloszen.php">Ogłoszenia</a>
    </div>

    <?php

    if(isset($_SESSION['email'])){
        if( $_SESSION["dostep"] == 3 || $_SESSION['dostep'] == 2){
            echo "<div class='menu_block_admin' >
            <a href='../panel.php'>
            <img src='../ikony/account.svg' width='16px' height='16px'>
            $_SESSION[email]
            </a>
            </div>";
        }
        else{
            echo "<div class='menu_block' >
            <img src='../ikony/account.svg' width='16px' height='16px'>
            $_SESSION[email]
            </div>";
        }

        echo "<div class='menu_block' >
        <a href='../wyloguj_conf.php'>
        <img src='../ikony/logout.svg' width='32px' height='32px'>
        </a>
        </div>";
    }
    else{
        echo     
        "<div class='menu_block'>
        <a href='../logowanie.php'>Zaloguj sie</a>
        </div>";
    }

    ?>


</div>