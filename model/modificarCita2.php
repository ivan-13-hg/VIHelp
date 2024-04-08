<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']) == 2 || $_SESSION['tipoUs'] == 3) { ?>
        <?php
        include ('../controller/Usuario.php');
        $u=Usuario::obtenerInstancia();

        $clave_cita=$_REQUEST['clave_cita'];
        $fecha_cita=$_REQUEST['fecha_cita'];
        $lugar_cita=$_REQUEST['lugar_cita'];
        $indi_cita=$_REQUEST['indi_cita'];
        $clave_doc = $_REQUEST['clave_doc'];
        $correo_us =  $_REQUEST['correo_us'];
        
        $u->modCita2($clave_cita,$fecha_cita,$lugar_cita,$indi_cita,$clave_doc,$correo_us);
        $u->desconectar();
        ?>
<?php
} else {
  echo'<script type="text/javascript">
  alert("Inicia Sesion");
  window.location.href="./index.php?pagina=IniciarSesion";
  </script>';
}
?>