<?php session_start();


  include ('../controller/Usuario.php');
  $u=Usuario::obtenerInstancia();
  $conexion= $u->obtenerConexion();
  //$conexion = mysqli_connect("localhost", "root", "", "vihelp") or die("Existen Problemas con la Base de Datos");

    $correo_doc = $_SESSION['usuario'];
    $tipo_us = $_SESSION['tipoUs'];
    $clave_doc ="";
    
		if($_SESSION['tipoUs'] == 2){
			$registroDoc=mysqli_query($conexion,"SELECT * FROM doctor WHERE correo_doc='$correo_doc' AND tipoUsuario = '$tipo_us'");
		$regDoc=mysqli_fetch_array($registroDoc);
		$clave_doc = $regDoc['iddoctor'];
		


		}else if($_SESSION['tipoUs'] == 3){
			$registroDoc=mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo_us='$correo_doc' AND tipoUsuario='$tipo_us'");
		$regDoc=mysqli_fetch_array($registroDoc);
		$clave_doc = $regDoc['clave_us'];
		

		}
    
    $registro=mysqli_query($conexion,"SELECT  
    U.clave_us AS claveus,
    U.apellidos_us AS apellidos,
    U.tipoUsuario AS tipoUsuario,
    U.correo_us AS correous
  
    FROM usuarios U
    WHERE (U.clave_us LIKE LOWER('%".$_POST['buscadorpaciente']."%') OR U.apellidos_us LIKE LOWER('%".$_POST['buscadorpaciente']."%'))
    AND U.tipoUsuario = '1'");
  if($reg=mysqli_fetch_array($registro)){
    $correo=$reg['correous'];
      $clave_us= $reg['claveus'];
    $consult = mysqli_query($conexion,"SELECT * FROM medicamentos WHERE Usuarios_clave_us = '$clave_us'");
    $consult2 = mysqli_query($conexion,"SELECT * FROM cita WHERE Usuarios_clave_us = '$clave_us'");  
      
            $u->listarusuariosDoctor($correo);
            ?>
            <div class="container text-center">
                <div class="text-center">
                    <h1>Registros</h1>
                    <hr />
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                        <div class="card mb-5 shadow-sm" style="border: var(--bs-card-border-width) solid rgb(0 0 0 / 13%)">
                            <div class='container marketing'>
                                <h1>Medicamentos registrados</h1>
                            </div>
                            
                            <?php
                            if (mysqli_num_rows($consult) >= 1) {

                            $u->MostrarMedicamentosDoctor($correo,$clave_us,$clave_doc,$tipo_us);
                            }else{

                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                        <div class="card mb-5 shadow-sm" style="border: var(--bs-card-border-width) solid rgb(0 0 0 / 13%)">
                            <div class='container marketing'>
                                <h1>Citas registradas</h1>
                            </div>
                            <?php
                            if (mysqli_num_rows($consult2) >= 1) {
                            $u->MostrarCitaDoctor($correo,$clave_doc);
                            }else{}
                            ?>
                        </div>
                    </div>
                </div>
            </div>

    
            
<?php

  }else{
    echo "No existe Registra al paciente";
  }



?>