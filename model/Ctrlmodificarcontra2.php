<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 1 || isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) { 
  include ('../controller/Usuario.php');
  $u=Usuario::obtenerInstancia();
  $correo_paciente=$_REQUEST['correo_uss'];
  $contrasena_us=$_REQUEST['contrasena_us'];
  $contra_actual=$_REQUEST['contra_actual'];

  
  $u->modificarContra2($contrasena_us,$correo_paciente,$contra_actual);
  $u->desconectar();
}  else {
  echo'<script type="text/javascript">
  alert("Inicia Sesion");
  window.location.href="./index.php?pagina=IniciarSesion";
  </script>';}
?>