<?php session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2) {
        header ('Location: ../index.php?pagina=perfilDoctor');
    }else{
        header ('Location: ../index.php?pagina=inicio');
    }
?>