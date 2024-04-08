<?php session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1 || $_SESSION['tipoUs'] == 2 || $_SESSION['tipoUs'] == 3) { 
  include ('../controller/Usuario.php');
  $u=Usuario::obtenerInstancia();
  $clave_us=$_REQUEST['clave_us'];
  $nombre_us=$_REQUEST['nombre_us'];
  $apellidos_us=$_REQUEST['apellidos_us'];
  $telefono_us=$_REQUEST['telefono_us'];
  $genero_us=$_REQUEST['genero_us'];
  $u->modificarUsuario2($clave_us,$nombre_us,$apellidos_us,$telefono_us,$genero_us);
  $u->desconectar();
} else {
  echo'<script type="text/javascript">
  alert("Inicia Sesion");
  window.location.href="./index.php?pagina=IniciarSesion";
  </script>';}
?>
