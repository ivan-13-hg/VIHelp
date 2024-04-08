<?php
header('Content-Type: application/json');

session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 1 ) {
  // Conectar a la base de datos
  $pdo = new PDO('mysql:host=localhost;dbname=vihelp','root','');
  $correo = $_SESSION['usuario'];
  $tipo_us = $_SESSION['tipoUs'];
  /*echo $tipo_us;
  echo $correo;*/
  // Obtener notificaciones programadas para la fecha y hora actual
  date_default_timezone_set('America/Mexico_City');
  $currentDateTime = date('Y-m-d H:i:s');
  $stmt = $pdo->prepare('SELECT  
                        U.clave_us AS claveus, 
                        N.idnotificacionMedicina AS idnoti, 
                        N.fecha_toma AS fechatoma,
                        N.claveMedicina AS claveMedicina, 
                        N.fecha_aplazada AS aplazada,
                        N.med_tomado AS ingerido, 
                        M.clave_med AS idmed, 
                        M.indicacion_med AS indicaciones, 
                        ME.nombre_med AS nombremed,
                        U.correo_us AS correous,
                        U.tipoUsuario AS tipoUsuario
                        FROM notificacionmedicina N
                        INNER JOIN medicamentos M ON M.clave_med = N.claveMedicina
                        INNER JOIN medicina ME ON ME.idmedicina = M.idmedicina
                        INNER JOIN usuarios U ON U.clave_us = M.Usuarios_clave_us
                        WHERE N.fecha_toma = :currentDateTime
                        AND U.correo_us = :correo
                        AND U.tipoUsuario = :tipoUsuario
                        ORDER BY N.fecha_toma ASC'
                        );

  $stmt->execute([':currentDateTime' => $currentDateTime,':correo' => $correo,':tipoUsuario' => $tipo_us]);
  $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
  /*foreach($notifications as $data){

    echo $data['tipoUsuario'];
  }*/
  // Enviar notificación como respuesta JSON
 
  echo json_encode(['notifications' => $notifications]);
}else {
    header('Location: ../index.php?pagina=IniciarSesion');
}
?>
