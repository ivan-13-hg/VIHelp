// En tu archivo PHP (posponerToma.php)
<?php
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 1 ){
include ('../controller/Usuario.php');
$u = Usuario::obtenerInstancia();
//$conexion = new PDO('mysql:host=localhost;dbname=vihelp','root','');
$conexion = $u->obtenerConexionPDO();
header('Content-Type: application/json'); // Indica que la respuesta es de tipo JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicamentoId = $_POST['idnoti'];
    $action = $_POST['action'];
    //echo json_encode(['status' => $medicamentoId, $action => 'Medicamento marcado como tomado']);
    $stmt = $conexion->prepare("SELECT * FROM notificacionMedicina WHERE idnotificacionMedicina = :idnotificacionMedicina");
    $stmt->execute([':idnotificacionMedicina' => $medicamentoId]);
    $reg = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($action === 'aplazar') {
        if ($reg) {
            $fechaCreada = date_create($reg['fecha_toma']);
            $fechaFormato = date_format($fechaCreada,'Y/m/d H:i:s');
            $sumaminutosFecha = strtotime($fechaFormato . "+ 5 minutes");
            $fechaFinal=date("Y/m/d G:i:s",$sumaminutosFecha);
            echo json_encode(['suma fecha' => $fechaFinal]);
            // Actualiza la base de datos con la nueva fecha y hora
            $updateNotiMed = "UPDATE notificacionMedicina SET fecha_toma = :sumaminutosFecha, fecha_aplazada = 2  WHERE idnotificacionMedicina = :idnoti";
            $actualizacion = $conexion->prepare($updateNotiMed);
            $actualizacion->bindParam(':sumaminutosFecha', $fechaFinal);
            $actualizacion->bindParam(':idnoti', $medicamentoId);
            
            if ($actualizacion->execute()) {
                echo json_encode(['status' => $medicamentoId, $action => 'Medicamento marcado como aplazado']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registro no encontrado']);
        }
    } else if ($action === 'tomado'){
        if ($reg) {
            // Actualiza la base de datos con la nueva fecha y hora
            $updateNotiMed = "UPDATE notificacionMedicina SET med_tomado = 2  WHERE idnotificacionMedicina = :idnoti";
            $actualizacion = $conexion->prepare($updateNotiMed);
            $actualizacion->bindParam(':idnoti', $medicamentoId);
            
            if ($actualizacion->execute()) {
                echo json_encode(['status' => $medicamentoId, $action => 'Medicamento marcado como tomado']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos']);
            }
        }
    }

} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
}
?>
