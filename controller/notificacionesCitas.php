<?php
header('Content-Type: application/json');
session_start();

include ('../controller/Usuario.php');
$u=Usuario::obtenerInstancia();
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']) == 1) {
  // Conectar a la base de datos
  //$pdo = new PDO('mysql:host=localhost;dbname=vihelp','root','');
  $pdo= $u->obtenerConexionPDO();
  $correo = $_SESSION['usuario'];
  // Obtener notificaciones programadas para la fecha y hora actual
  date_default_timezone_set('America/Mexico_City');
  $currentDateTime = date('Y-m-d H:i:s');
  $stmtt = $pdo->prepare('SELECT  
                        U.clave_us AS claveus, 
                        N.idnotificacionCitas AS idcita, 
                        N.fecha_cita AS fechacita, 
                        C.clave_cita AS idcita, 
                        C.indi_cita AS indicita, 
                        C.lugar_cita AS lugarcita,
                        U.correo_us AS correous
                        FROM notificacionCitas N
                        INNER JOIN cita C ON C.clave_cita = N.claveCita
                        INNER JOIN usuarios U ON U.clave_us = C.Usuarios_clave_us
                        WHERE N.fecha_cita = :currentTime
                        AND U.correo_us = :correo
                        ORDER BY N.fecha_cita ASC'
                        );
  $stmtt->execute([':currentTime' => $currentDateTime,':correo' => $correo]);
  $notification = $stmtt->fetchAll(PDO::FETCH_ASSOC);
  // Enviar notificación como respuesta JSON
  echo json_encode(['notificacion' => $notification]);
}else {
    header('Location: ../index.php?pagina=IniciarSesion');
}
?>
