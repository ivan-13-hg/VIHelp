<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 1 || isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) { 
  include ('../controller/Usuario.php');
        $u=Usuario::obtenerInstancia();
        $correo_paciente=$_REQUEST['correo_uss'];
        $nombre_imagen=$_FILES['foto_us']['name'];
        $temporal=$_FILES['foto_us']['tmp_name'];
        $carpeta='../view/assets/img';
        $carpetamuestra='./view/assets/img';
        $foto_us=$carpetamuestra.'/'.$nombre_imagen;
        move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);
  	    $u->modificarFoto2($foto_us,$correo_paciente);
	      $u->desconectar();
} else {
  echo'<script type="text/javascript">
  alert("Inicia Sesion");
  window.location.href="./index.php?pagina=IniciarSesion";
  </script>';}
?>