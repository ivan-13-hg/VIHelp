<?php session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1) {
        header ('Location: ../index.php?pagina=perfil');
    }else if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3) {
        header ('Location: ../index.php?pagina=perfilAdmin');        
    }
    else{
        header ('Location: ../index.php?pagina=RegistroUsuario');
    }
?>