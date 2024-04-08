<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 ) {
        include ('../controller/Usuario.php');
        $u=Usuario::obtenerInstancia();

        $correo_us=$_REQUEST['correo_us'];
        $clave_med=$_REQUEST['clave_med'];
        $nombre_med=$_REQUEST['nombre_med'];
        $forma_med=$_REQUEST['forma_med'];
        $dosis_med=$_REQUEST['dosis_med'];
        $fre_med=$_REQUEST['fre_med'];
        $via_med=$_REQUEST['via_med'];
        $duracion_med=$_REQUEST['duracion_med'];
        $indicacion_med=$_REQUEST['indicacion_med'];
        $fecha_med=$_REQUEST['fecha_med'];
        $clave_doc=$_REQUEST['clave_doc'];
        $u->formModMedicamento2($clave_med,$nombre_med,$forma_med,$dosis_med,$fre_med,$via_med,$duracion_med,$indicacion_med,$fecha_med,$correo_us,$clave_doc);
        $u->desconectar();
        

    
       
} else {
  echo'<script type="text/javascript">
  alert("Inicia Sesion");
  window.location.href="./index.php?pagina=IniciarSesion";
  </script>';}?>