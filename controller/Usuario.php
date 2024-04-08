<?php
class Usuario{

	//Uso del patron de diseño Singleton para la coneccion a la base de datos
	/*Singleton (obtenerInstancia):
	La variable private static $instancia asegura que solo haya una instancia de la clase Usuario. Si no existe una instancia, 
	se crea una mediante el constructor privado __construct. El método obtenerInstancia se encarga de devolver siempre la misma instancia única.*/ 
	private static $instancia;  // Variable para almacenar la única instancia
    private $conexion;          // Variable para almacenar la conexión a la base de datos
	private $conexionpdo;
	private $nombre_us;
	private $apellidos_us;
	private $telefono_us;
	private $correo_us;
	private $contrasena_us;
	private $foto_us;
 

    // Constructor privado para prevenir la creación de instancias desde fuera de la clase
    public function __construct() {
	$DB_HOST= getenv('DB_HOST');
	$DB_USER= getenv('DB_USER');
	$DB_PASSWORD = getenv('DB_PASSWORD');
	$DB_NAME = getenv('DB_NAME');
	$DB_PORT = getenv('DB_PORT');

	/*$DB_HOST= "viaduct.proxy.rlwy.net";
	$DB_USER= "root";
	$DB_PASSWORD = "qRalDxPcmepuqgcpPrjtTfLxNSAlZkah";
	$DB_NAME = "railway";
	$DB_PORT = "11147";*/

        //$this->conexion = mysqli_connect("localhost","root","","vihelp",3306);
		$this->conexion = mysqli_connect("$DB_HOST","$DB_USER","$DB_PASSWORD","$DB_NAME","$DB_PORT");


		$this->conexionpdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME",$DB_USER,$DB_PASSWORD);
    }
    // Método para obtener la instancia única de Usuario
    public static function obtenerInstancia() {
        if (!isset(self::$instancia)) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }
    // Método para obtener la conexión a la base de datos
    public function obtenerConexion() {
        return $this->conexion;
    }
	public function obtenerConexionPDO() {
        return $this->conexionpdo;
    }
	public function inicializar($nombre_us,$apellidos_us,$telefono_us,$correo_us,$contrasena_us,$foto_us){
		$this->nombre_us=$nombre_us;
		$this->apellidos_us=$apellidos_us;
		$this->telefono_us=$telefono_us;
		$this->correo_us=$correo_us;
		$this->contrasena_us=$contrasena_us;
		$this->foto_us=$foto_us;
	}
	/*public function conexion(){
		$con = mysqli_connect("localhost","root","","ls") or die("Existen Problemas con la Base de Datos");
		return $con;
	}*/
 	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------CONTROL USUARIO---------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	//Ingresar usuario
	public function ingresarUsuario($contrasena_us){
		$registro=mysqli_query($this->obtenerConexion(),"select clave_us,nombre_us,apellidos_us,telefono_us,correo_us,contrasena_us,foto_us
		from usuarios where correo_us='$this->correo_us'") or die("Problemas en el Select: ".mysqli_error($this->obtenerConexion()));
		if($reg=mysqli_fetch_array($registro)){
			if($_SESSION['tipoUs'] == 2){
				echo'<script type="text/javascript">
			alert("Correo ya registrado");
			window.location.href="../index.php?pagina=perfilDoctor";
			</script>';
			}else if($_SESSION['tipoUs'] == 3){
				echo'<script type="text/javascript">
			alert("Correo ya registrado");
			window.location.href="../index.php?pagina=perfilAdmin";
			</script>';
			}
		}else{
		$contrasena_us = hash('sha512',$contrasena_us);
		$conn=$this->obtenerConexion();
		$ingresarPaciente = "INSERT INTO usuarios(clave_us,nombre_us,apellidos_us,telefono_us,correo_us,contrasena_us,foto_us,tipoUsuario) VALUES 
		(NULL,'$this->nombre_us','$this->apellidos_us','$this->telefono_us','$this->correo_us','$contrasena_us','$this->foto_us',1)";
		$conn->query($ingresarPaciente);
		$idPacienteIngresado = $conn->insert_id;
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
			echo'<script type="text/javascript">
			alert("Registro de Paciente Realizado con ID : '.$idPacienteIngresado.' Ahora puede Buscarlo");
			window.location.href="../index.php?pagina=perfilDoctor";
			</script>';			
		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==3 ){
			echo'<script type="text/javascript">
			alert("Registro de Paciente Realizado con ID : '.$idPacienteIngresado.' Ahora puede Buscarlo");
			window.location.href="../index.php?pagina=perfilAdmin";
			</script>';			
		}
		//header("location: ../vistas/IniciarSesion.php");
		}
	}
	//Iniciar Sesion
	public function entrar($correo_us,$contrasena_us){

		$contrasena_us = hash('sha512',$contrasena_us);
		$logDoctor=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor WHERE correo_doc = '$correo_us' AND contrasena_doc = '$contrasena_us' ");

		$logUsuario=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us = '$correo_us' AND contrasena_us = '$contrasena_us' ");
		
		if($regUsuario=mysqli_fetch_array($logUsuario)){
			$tipoUsuario = $regUsuario['tipoUsuario'];
			if($tipoUsuario == 1){
				session_start();
				$_SESSION['usuario']=$correo_us;
				$_SESSION['tipoUs']=$tipoUsuario;
				include ("../controller/ctrlinicio.php");
			}else if($tipoUsuario == 3){
				session_start();
				$_SESSION['usuario']=$correo_us;
				$_SESSION['tipoUs']=$tipoUsuario;
				include ("../controller/ctrlinicio.php");
			}
		}else if($regDoctor=mysqli_fetch_array($logDoctor)){
			$tipoUsuario = $regDoctor['tipoUsuario'];
			if($tipoUsuario == 2){
				session_start();
				$_SESSION['usuario']=$correo_us;
				$_SESSION['tipoUs']=$tipoUsuario;
				include ("../controller/ctrliniciodoctor.php");
				}
		}else{
			echo'<script type="text/javascript">
			alert("Contraseña o Correo Invalidos");
			window.location.href="../index.php?pagina=IniciarSesion";
			</script>';
			//include ("../vistas/IniciarSesion.php");	
		//header("location: ../vistas/IniciarSesion.php");
		}
	}
	//Listar Usuario Perfil
	public function listarUsuarios(){
		$correo = $_SESSION['usuario'];
		$tipoUs = $_SESSION['tipoUs'];
		echo $tipoUs;
		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us='$correo'");		
		while($reg=$registro->fetch_assoc()){
		//Perfil	
		echo "
		<div class='container marketing py-5'>
			<div class='text-center my-5'>
				<h1>Perfil</h1>
				<h3>ID:".$reg['clave_us'] ." </h3>
			</div>
			<div class='card' style='border:unset; align-items: center;'>
				<img src='".$reg['foto_us']."' class='' style='object-fit:contain;object-position:center;border-radius:500px;width:200px;height:200px;' alt='...'>
				<div class='card-body d-flex flex-column align-items-center ' style='width:100%;'>
      				<h5 class='card-title'>".$reg['nombre_us'] ."  ". $reg['apellidos_us']."</h5>
	  				<div class='card-body p-4 ' style='width:100%;'>
	  					<hr class='mt-0 mb-4'>
	  					<div class='row pt-1' style=''>
							<div class='col-6 mb-3' style='display:flex;flex-direction:column;align-items:center;'>
						    	<h6>Email</h6>
		  						<p class='text-muted'>".$reg['correo_us']."</p>
							</div>
							<div class='col-6 mb-3' style='display:flex;flex-direction:column;align-items: center;'>
								<h6>Phone</h6>
								<p class='text-muted'>".$reg['telefono_us']."</p>
							</div>
	  					</div>
	 				</div> 
    			</div>
			</div>
			

			<ul class='nav justify-content-evenly'>
				<li class=' btn btn-outline-primary mt-2' style='padding:0;display:flex;width:162px;height:48px;align-items:center;justify-content:center;'>
					<a class=' dropdown-toggle btn ' style='width: 100%;
					height: 100%;
					padding: 0;
					display: flex;
					align-items: center;
					justify-content: center;' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>Editar Perfil</a>
					<ul class='dropdown-menu'>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal3'>Editar Datos</a></li>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal5'>Editar Contraseña</a></li>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal4'>Editar Foto</a></li>
					</ul>
				</li>
					<div class='modal fade' id='exampleModal3' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Perfil</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body'>
											<form  action='./model/CtrlModificarU2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModDatosPaciente();'> 
											<div class='mb-3'>
													<label for='nombre_us' class='col-form-label'>Nombre(s)</label>
													<input type='text' class='form-control' name='nombre_us' id='nombre_us' value='".$reg["nombre_us"]."'>
												</div>
												<div class='mb-3'>
													<label for='apellidos_us' class='col-form-label'>Apellidos(s)</label>
													<input type='text' class='form-control' id='apellidos_us'  name='apellidos_us' value='".$reg["apellidos_us"]."'>
												</div>
												<div class='mb-3'>
													<label for='telefono_us' class='col-form-label'>Telefono</label>
													<input type='text' class='form-control' id='telefono_us' name='telefono_us' value='".$reg["telefono_us"]."'>
												</div>
												<div class='mb-3'>
													<label for='genero_us' class='col-form-label'>Genero</label>
													<input type='text' class='form-control' id='genero_us' name='genero_us' value='".$reg["genero_us"]."'>
												</div>
												<input type='hidden' name='clave_us' value='".$reg["clave_us"]."'>
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												
											</div>
											</form>
										</div>
									</div>
					</div>
					<div class='modal fade' id='exampleModal4' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog '>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Foto</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body d-flex align-items-center justify-content-center'>
											<form onsubmit='return ValidacionModFotoPacienteAdmin();' action='./model/modificarFoto2.php' method='post' enctype='multipart/form-data' class='d-flex align-items-center flex-column'> 
											<img class='img-form' src='".$reg["foto_us"]."' width='100' height='100'>
													<div class='mb-3'>
														<label for='fotous' class='col-form-label'>Selecciona la Imagen</label>
														
														<input require type='file' id='fotous' name='foto_us' value='".$reg["foto_us"]."'>
														<input type='hidden' name='correo_uss' value='".$reg['correo_us']."'>
													</div>

													
													
													<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
													</div>
												</form>
											</div>
										</div>
									</div>
					</div>
					<div class='modal fade' id='exampleModal5' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Contraseña</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body'>
											<form  action='./model/Ctrlmodificarcontra2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModContraPaciente();'> 
													<div class='mb-3'>
														<label for='contra_actual' class='col-form-label'>Contraseña Actual</label>
														<input type='password' id='contra_actual' name='contra_actual' class='form-control' autocomplete='on'>
													</div>
													<div class='mb-3'>
														<label for='contrasena_us' class='col-form-label'>Contraseña Nueva</label>
														<input type='password' id='contrasena_us' class='form-control' name='contrasena_us' autocomplete='on'>
													</div>
													<div class='mb-3'>
														<label for='contra_repeat' class='col-form-label'>Repite la Contraseña</label>
														<input type='password' id='contra_repeat' class='form-control' autocomplete='on'>
													</div>			
													<input type='hidden' name='correo_uss' value='".$reg['correo_us']."'>
								
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												</form>
											</div>
										</div>
									</div>
					</div>
			</ul>
		</div>";
		}
	}
	//Modificar Foto
	public function modificarFoto2($foto_us,$correo_paciente){
		
		$registro=mysqli_query($this->obtenerConexion(),"UPDATE usuarios set foto_us='$foto_us'
		where correo_us='$correo_paciente'");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1){
			echo'<script type="text/javascript">
			alert("Foto Modificada");
			window.location.href="../index.php?pagina=perfil";
			</script>';			}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2 ){
				echo'<script type="text/javascript">
				alert("Foto Modificada");
				window.location.href="../index.php?pagina=perfilDoctor";
				</script>';
				}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
				echo'<script type="text/javascript">
				alert("Foto Modificada");
				window.location.href="../index.php?pagina=perfilAdmin";
				</script>';			}
	}
	//Modificar Usuario
	public function modificarUsuario2($clave_us,$nombre_us,$apellidos_us,$telefono_us,$genero_us){
		$registro=mysqli_query($this->obtenerConexion(),"UPDATE usuarios set nombre_us='$nombre_us',apellidos_us='$apellidos_us',telefono_us='$telefono_us',genero_us='$genero_us'
		where clave_us='$clave_us'");
		
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==1){
		header("location: ../index.php?pagina=perfil");
		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
		header("location: ../index.php?pagina=perfilDoctor");
		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==3 ){
		header("location: ../index.php?pagina=perfilAdmin");
		}


	}
	//Modificar Contraseña
	public function modificarContra2($contrasena_us,$correo_paciente,$contra_actual){
	
		$contrasena_us = hash('sha512',$contrasena_us);
		$contrasena_actual = hash('sha512',$contra_actual);
		$consulta=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us='$correo_paciente'");
		$respuesta=$consulta->fetch_assoc();

		if($contrasena_actual== $respuesta['contrasena_us']){
			$registro=mysqli_query($this->obtenerConexion(),"UPDATE usuarios set contrasena_us='$contrasena_us' where correo_us='$correo_paciente'");
			if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1 ){
				header("location: ../index.php?pagina=perfil");
			}
		}else{
			if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1){
					echo'<script type="text/javascript">
				alert("La contraseña actual no coincide con la registrada");
				window.location.href="../index.php?pagina=perfil";
				</script>';
			}
			
		}
	}
	public function modificarContraAdmin($contrasena_us,$clave_us,$contrasena_actual){
	
		$contrasena_us = hash('sha512',$contrasena_us);
		$contrasena_actual = hash('sha512',$contrasena_actual);
		$consulta=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE clave_us='$clave_us'");
		$respuesta=$consulta->fetch_assoc();

		if($contrasena_actual== $respuesta['contrasena_us']){
			$registro=mysqli_query($this->obtenerConexion(),"UPDATE usuarios set contrasena_us='$contrasena_us' where clave_us='$clave_us'");
			if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3){
				header("location: ../index.php?pagina=perfilAdmin");
			}
		}else{
			if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3){
				echo'<script type="text/javascript">
				alert("La contraseña actual no coincide con la registrada");
				window.location.href="../index.php?pagina=perfilAdmin";
				</script>';
			}
			
		}
	}
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-------------------MEDICAMENTOS----------------*/
	/*-------------------TRATAMIENTOS----------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	//Formulario Agregar Medicamento
	//Agregar Medicamento(Tratamiento)
	public function AgregarMedicamento($nombre_med,$forma_med,$dosis_med,$fre_med,$via_med,$duracion_med,$indicacion_med,$fecha_med,$clave_us,$clave_doc){
		$conn=$this->obtenerConexion();
		echo $_SESSION['tipoUs'];
		$idMedicamento="";
		if($_SESSION['tipoUs'] == 2){
			
			$insertarMedicamento = "INSERT INTO medicamentos(idmedicina,idformaMedica,dosis_med,fre_med,idviaMedica,duracion_med,indicacion_med,fecha_med,fecharegistroMed,Usuarios_clave_us,iddoctor,claveAdmin) VALUES 
		('$nombre_med','$forma_med','$dosis_med','$fre_med','$via_med','$duracion_med','$indicacion_med','$fecha_med',NOW(),'$clave_us','$clave_doc',NULL)";
		 $conn->query($insertarMedicamento);
			$idMedicamento = $conn->insert_id;
			
		}
		else if($_SESSION['tipoUs'] == 3){
			$insertarMedicamento = "INSERT INTO medicamentos(idmedicina,idformaMedica,dosis_med,fre_med,idviaMedica,duracion_med,indicacion_med,fecha_med,fecharegistroMed,Usuarios_clave_us,iddoctor,claveAdmin) VALUES 
		('$nombre_med','$forma_med','$dosis_med','$fre_med','$via_med','$duracion_med','$indicacion_med','$fecha_med',NOW(),'$clave_us',NULL,'$clave_doc')";
		$conn->query($insertarMedicamento);
		$idMedicamento = $conn->insert_id;
		}
		mysqli_query($this->obtenerConexion(),"INSERT INTO citatratamiento(fecha_citaTratamiento,numeroCita,claveMedicina) VALUES (NOW(),1,'$idMedicamento') ");

		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicamentos where Usuarios_clave_us='$clave_us' AND clave_med='$idMedicamento'");
		
		date_default_timezone_set('America/Mexico_City');
		$fechaActual = date("Y/m/d G:i:s");
		while($reg=mysqli_fetch_array($registro)){
			$clave_med = $reg['clave_med'];
			$frecuencia=$reg['fre_med'];
			$duracion=$reg['duracion_med'];
			//Fecha de Inicio Registrada en la base de datos y le damos el formato con el que aremos operaciones.
			$fechaCreada=date_create($reg['fecha_med']);
			$fechaInicio=date_format($fechaCreada,'Y/m/d G:i:s');
			$logg=mysqli_query($this->obtenerConexion(),"SELECT  *                
			FROM notificacionMedicina N, medicamentos M
			WHERE M.Usuarios_clave_us ='$clave_us' 
			AND N.claveMedicina ='$clave_med'
			ORDER BY N.fecha_toma ASC");
			if($reggg=mysqli_fetch_array($logg)){}else{
			mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionMedicina(idnotificacionMedicina,fecha_toma,fecha_aplazada,med_tomado,claveMedicina) VALUES 
			(NULL,'$fechaInicio',1,1,'$clave_med')");}
			//Fecha de Inicio Registrada en la base de datos + los dias a ingerir el medicamento ($duracion)
			$sumaFechaFinal = strtotime($fechaInicio."+".$duracion." days");
			$fechaFinal=date("Y/m/d G:i:s",$sumaFechaFinal);
			//Se convierten las fechas a segundos y se se saca la diferencia para calcular los seg/min/hrs/dias/meses/años.
			$segundosFechaInicio=strtotime($fechaInicio);
			$segundosFechaFinal=strtotime($fechaFinal);
			$segundosDeDirencia= $segundosFechaFinal - $segundosFechaInicio;
			//Se convierte de seg a minutos.
			$min = $segundosDeDirencia/60;
			//Se convierte de min a horas.
			$hor = $min/60;
			//Se convierte de horas a dias.
			$dia = $hor/24;
			$suma=0;
			for($i=0;$i<=$hor;$i++){
				$suma+=$frecuencia;
				if($suma<$hor){
				//Muestra la Fecha y hora de la toma de medicamentos cada x tiempo y se los suma //	
				$mo_date = strtotime($fechaInicio."+".$suma." hours");
				$toma=date("Y/m/d G:i:s",$mo_date);
				//Muestra la Fecha y hora Actual con 20 seg mas//	
				$m_date = strtotime($toma."+ 2 second");
				$tom=date("Y/m/d G:i:s",$m_date);
				//Fecha de Inicio de medicmento con 59 seg mas
				$fechaInicioMas = strtotime($fechaInicio."+ 59 second");
				$fechaInicioSumada=date("Y/m/d G:i:s",$fechaInicioMas);
				$loggg=mysqli_query($this->obtenerConexion(),"SELECT  *                
				FROM notificacionMedicina N ,medicamentos M
				
				WHERE M.Usuarios_clave_us ='$clave_us' 
				AND N.claveMedicina ='$clave_med'
				AND N.fecha_toma= '$toma'
				ORDER BY N.fecha_toma ASC");
				if($regggg=mysqli_fetch_array($loggg)){}else{mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionMedicina(idnotificacionMedicina,fecha_toma,fecha_aplazada,med_tomado,claveMedicina) VALUES 
				(NULL,'$toma',1,1,'$clave_med')");}
				} 
			}
		}
		if($_SESSION['tipoUs'] == 2){
			echo'<script type="text/javascript">
		alert("Medicamento registrado"+"'.$idMedicamento.'");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
		}else if($_SESSION['tipoUs'] == 3){
			echo'<script type="text/javascript">
		alert("Medicamento registrado"+"'.$idMedicamento.'");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';
		}
		
	}
	//Modificar Medicamento
	public function formModMedicamento2($clave_med,$nombre_med,$forma_med,$dosis_med,$fre_med,$via_med,$duracion_med,$indicacion_med,$fecha_med,$correo_us,$clave_doc){
		
		$clave=mysqli_query($this->obtenerConexion(),"select clave_us from usuarios where correo_us='$correo_us'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];
		/*$registro=mysqli_query($this->conexion(),"select * from medicamentos where TIME(fecha_med)=TIME('$fecha_med')");
		if($reg=mysqli_fetch_array($registro)){
			$nom=$reg['nombre_med'];
		echo'<script type="text/javascript">
		const nombremed = '.json_encode($nom).';
		console.log(nombremed);
        alert(`El Medicamento ${nombremed} ya se encuentra registrado a la misma hora , Para evitar complicaciones toma un lapso mayor a 10 min para Modificarlo`);
        window.location.href="../index.php?pagina=perfil";
        </script>';
		}else{*/
		mysqli_query($this->obtenerConexion(),"DELETE N               
		FROM notificacionMedicina N
		INNER JOIN medicamentos M ON M.clave_med = N.claveMedicina
		INNER JOIN usuarios U ON U.clave_us = M.Usuarios_clave_us
		WHERE M.Usuarios_clave_us ='$clave_us' 
		AND N.claveMedicina ='$clave_med' 
		");
		
		mysqli_query($this->obtenerConexion(),"UPDATE medicamentos set 
		idmedicina ='$nombre_med',
		idformaMedica ='$forma_med',
		dosis_med ='$dosis_med',
		fre_med ='$fre_med',
		idviaMedica ='$via_med',
		duracion_med ='$duracion_med',
		indicacion_med ='$indicacion_med',
		fecha_med = '$fecha_med'
		where clave_med='$clave_med'");

		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicamentos where Usuarios_clave_us='$clave_us' AND clave_med='$clave_med'");
		
		
			date_default_timezone_set('America/Mexico_City');
			$fechaActual = date("Y/m/d G:i:s");
		while($reg=mysqli_fetch_array($registro)){
			$clave_med = $reg['clave_med'];
			$frecuencia=$reg['fre_med'];
			$duracion=$reg['duracion_med'];
			//Fecha de Inicio Registrada en la base de datos y le damos el formato con el que aremos operaciones.
			$fechaCreada=date_create($reg['fecha_med']);
			$fechaInicio=date_format($fechaCreada,'Y/m/d G:i:s');
			$logg=mysqli_query($this->obtenerConexion(),"SELECT  *                
			FROM notificacionMedicina N
			INNER JOIN medicamentos M ON M.clave_med = N.claveMedicina
				INNER JOIN usuarios U ON U.clave_us = M.Usuarios_clave_us
			WHERE M.Usuarios_clave_us ='$clave_us' 
			AND N.claveMedicina ='$clave_med'
			ORDER BY N.fecha_toma ASC");
			if($reggg=mysqli_fetch_array($logg)){}else{
			mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionMedicina(idnotificacionMedicina,fecha_toma,fecha_aplazada,med_tomado,claveMedicina) VALUES 
			(NULL,'$fechaInicio',1,1,'$clave_med')");}
			//Fecha de Inicio Registrada en la base de datos + los dias a ingerir el medicamento ($duracion)
			$sumaFechaFinal = strtotime($fechaInicio."+".$duracion." days");
			$fechaFinal=date("Y/m/d G:i:s",$sumaFechaFinal);
			//Se convierten las fechas a segundos y se se saca la diferencia para calcular los seg/min/hrs/dias/meses/años.
			$segundosFechaInicio=strtotime($fechaInicio);
			$segundosFechaFinal=strtotime($fechaFinal);
			$segundosDeDirencia= $segundosFechaFinal - $segundosFechaInicio;
			//Se convierte de seg a minutos.
			$min = $segundosDeDirencia/60;
			//Se convierte de min a horas.
			$hor = $min/60;
			//Se convierte de horas a dias.
			$dia = $hor/24;
			$suma=0;
			for($i=0;$i<=$hor;$i++){
				$suma+=$frecuencia;
				if($suma<$hor){
				//Muestra la Fecha y hora de la toma de medicamentos cada x tiempo y se los suma //	
				$mo_date = strtotime($fechaInicio."+".$suma." hours");
				$toma=date("Y/m/d G:i:s",$mo_date);
				//Muestra la Fecha y hora Actual con 20 seg mas//	
				$m_date = strtotime($toma."+ 2 second");
				$tom=date("Y/m/d G:i:s",$m_date);
				//Fecha de Inicio de medicmento con 59 seg mas
				$fechaInicioMas = strtotime($fechaInicio."+ 59 second");
				$fechaInicioSumada=date("Y/m/d G:i:s",$fechaInicioMas);
				$loggg=mysqli_query($this->obtenerConexion(),"SELECT  *                
				FROM notificacionMedicina N
				INNER JOIN medicamentos M ON M.clave_med = N.claveMedicina
				INNER JOIN usuarios U ON U.clave_us = M.Usuarios_clave_us
				WHERE M.Usuarios_clave_us ='$clave_us' 
				AND N.claveMedicina ='$clave_med'
				AND N.fecha_toma= '$toma'
				ORDER BY N.fecha_toma ASC");
				if($regggg=mysqli_fetch_array($loggg)){}else{mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionMedicina(idnotificacionMedicina,fecha_toma,fecha_aplazada,med_tomado,claveMedicina) VALUES 
				(NULL,'$toma',1,1,'$clave_med')");}
				} 
			}
		}
		if($_SESSION['tipoUs'] == 2){
			echo'<script type="text/javascript">
		alert("Tratamiento Modificado");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
		}else if($_SESSION['tipoUs'] == 3){
			echo'<script type="text/javascript">
		alert("Tratamiento Modificado");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';
		}
		
		//}	
	}
	//Mostrar Medicamentos
	public function MostrarMedicamentos(){
		$correo = $_SESSION['usuario'];
		$tipous = $_SESSION['tipoUs'];
		$clave=mysqli_query($this->obtenerConexion(),"select * from usuarios where correo_us='$correo' AND tipoUsuario ='$tipous'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];
		$registro=mysqli_query($this->obtenerConexion(),"SELECT  
		M.clave_med,M.idmedicina,M.idformaMedica,M.dosis_med,M.fre_med,
		M.idviaMedica,M.duracion_med,M.indicacion_med,M.fecha_med,M.Usuarios_clave_us,
		M.iddoctor,F.forma_medicina,V.via_med,ME.nombre_med
		FROM medicamentos M
		INNER JOIN medicina ME ON ME.idmedicina = M.idmedicina
		INNER JOIN viamedica V ON V.idviaMedica = M.idviaMedica
		INNER JOIN formamedica F ON F.idformaMedica = M.idformaMedica
		WHERE M.Usuarios_clave_us ='$clave_us' 
		ORDER BY M.clave_med ASC");
	
		date_default_timezone_set('America/Mexico_City');
		$fechaActual = date("Y/m/d G:i:s");
		while($reg=mysqli_fetch_array($registro)){
			$clave_med = $reg['clave_med'];
			$frecuencia=$reg['fre_med'];
			$duracion=$reg['duracion_med'];
			//Fecha de Inicio Registrada en la base de datos y le damos el formato con el que aremos operaciones.
			$fechaCreada=date_create($reg['fecha_med']);
			$fechaInicio=date_format($fechaCreada,'Y/m/d G:i:s');
			//Fecha de Inicio Registrada en la base de datos + los dias a ingerir el medicamento ($duracion)
			$sumaFechaFinal = strtotime($fechaInicio."+".$duracion." days");
			$fechaFinal=date("Y/m/d G:i:s",$sumaFechaFinal);
			//Se convierten las fechas a segundos y se se saca la diferencia para calcular los seg/min/hrs/dias/meses/años.
			echo "
				<div class='accordion' id='accordionExample'>
					<div class='accordion-item'>
						<h2 class='accordion-header'>
							<button  class='btn collapsed w-100 text-white' style='
							background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,152,155,1) 0.1%, rgba(0,94,120,1) 94.2% );							
							border-color:linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo".$reg['clave_med']."' aria-expanded='false' aria-controls='collapseTwo'>
							<p>Nombre del Medicamento : ".$reg['nombre_med']."</p>
							<p>Fecha de inicio:".$fechaInicio."</p>
							<p>Fecha Final: ".$fechaFinal. "</p>
							</button>
						</h2>
						<div id='collapseTwo".$reg['clave_med']."' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
							<div class='accordion-body'>
								<p>Forma Medica : ".$reg['forma_medicina']."</p>
								<p>Dosis : ".$reg['dosis_med']."</p>
								<p>Via : ".$reg['via_med']."</p>

								<p>Tomar cada ".$reg['fre_med']." Hrs.</p>
								<p>Por ".$reg['duracion_med']." Dias</p>
								
								<p>Indicaciones: <br>".$reg['indicacion_med']."</p>
								<hr>
							</div>
						</div>	
					</div>
				</div>
			";
		}
		echo "";
	}
	public function MostrarMedicamentosDoctor($correo,$clave_us,$clave_doc){
		
		$registro=mysqli_query($this->obtenerConexion(),"SELECT  
		M.clave_med,M.idmedicina,M.idformaMedica,M.dosis_med,M.fre_med,
		M.idviaMedica,M.duracion_med,M.indicacion_med,M.fecha_med,M.Usuarios_clave_us,
		M.iddoctor,F.forma_medicina,V.via_med,ME.nombre_med
		FROM medicamentos M
		INNER JOIN medicina ME ON ME.idmedicina = M.idmedicina
		INNER JOIN viamedica V ON V.idviaMedica = M.idviaMedica
		INNER JOIN formamedica F ON F.idformaMedica = M.idformaMedica
		WHERE M.Usuarios_clave_us ='$clave_us' 
		ORDER BY M.clave_med ASC");

		
		date_default_timezone_set('America/Mexico_City');
		$fechaActual = date("Y/m/d G:i:s");
		while($reg=mysqli_fetch_array($registro)){
			$clave_med = $reg['clave_med'];
			$frecuencia=$reg['fre_med'];
			$duracion=$reg['duracion_med'];
			//Fecha de Inicio Registrada en la base de datos y le damos el formato con el que aremos operaciones.
			$fechaCreada=date_create($reg['fecha_med']);
			$fechaInicio=date_format($fechaCreada,'Y/m/d G:i:s');
			//Fecha de Inicio Registrada en la base de datos + los dias a ingerir el medicamento ($duracion)
			$sumaFechaFinal = strtotime($fechaInicio."+".$duracion." days");
			$fechaFinal=date("Y/m/d G:i:s",$sumaFechaFinal);
			//Se convierten las fechas a segundos y se se saca la diferencia para calcular los seg/min/hrs/dias/meses/años.
			$segundosFechaInicio=strtotime($fechaInicio);
			$segundosFechaFinal=strtotime($fechaFinal);
			$segundosDeDirencia= $segundosFechaFinal - $segundosFechaInicio;
			//Se convierte de seg a minutos.
			$min = $segundosDeDirencia/60;
			//Se convierte de min a horas.
			$hor = $min/60;
			//Se convierte de horas a dias.
			$dia = $hor/24;
			$suma=0;
			for($i=0;$i<=$hor;$i++){
				$suma+=$frecuencia;
				if($suma<$hor){
				//Muestra la Fecha y hora de la toma de medicamentos cada x tiempo y se los suma //	
				$mo_date = strtotime($fechaInicio."+".$suma." hours");
				$toma=date("Y/m/d G:i:s",$mo_date);
				//Muestra la Fecha y hora Actual con 20 seg mas//	
				$m_date = strtotime($toma."+ 2 second");
				$tom=date("Y/m/d G:i:s",$m_date);
				//Fecha de Inicio de medicmento con 59 seg mas
				$fechaInicioMas = strtotime($fechaInicio."+ 59 second");
				$fechaInicioSumada=date("Y/m/d G:i:s",$fechaInicioMas);

				} 
			}
			
			echo "
				<div class='accordion' id='accordionExample'>
					<div class='accordion-item'>
						<h2 class='accordion-header'>
							<button  class='btn collapsed w-100 text-white' style='
							background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,152,155,1) 0.1%, rgba(0,94,120,1) 94.2% );							
							border-color:linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo".$reg['clave_med']."' aria-expanded='false' aria-controls='collapseTwo'>
							<p>Medicamento : ".$reg['nombre_med']."</p>

							<p>Fecha de inicio:".$fechaInicio."</p>
							</button>
						</h2>
						
						<div id='collapseTwo".$reg['clave_med']."' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
							<div class='accordion-body'>
								<div class='row'>
									<div class='col-lg-6 col-md-6 col-sm-12 '>
										<p>Forma Medica : ".$reg['forma_medicina']."</p>
										<p>Via de Ingesta : ".$reg['via_med']."</p>
										<p>Dosis : ".$reg['dosis_med']."</p>
										<p>Cada ".$reg['fre_med']." Hrs</p>
										<p>Por ".$reg['duracion_med']." Dias</p>
										
										<div class='container d-flex flex-column align-items-center'>
											<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' 
											data-bs-target='#exampleModalHorarios".$reg['clave_med']."' data-bs-whatever='@mdo'>Horarios</button>
											<div class='modal fade' id='exampleModalHorarios".$reg['clave_med']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
												<div class='modal-dialog modal-xl'>
													<div class='modal-content'>
														<div class='modal-header'>
															<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
														</div>

														<div class='row'>
															<div class='col-lg-6 col-md-6 col-sm-12'>
																<h1 class='modal-title fs-5' id='exampleModalLabel'>Hararios de Toma</h1>

																<div class='container-fluid marketing py-5'>
																	<table class='table'>
																		<thead>
																			<tr>
																				<th scope='col'>#</th>
																				<th scope='col'>Fecha de Toma</th>
																				<th scope='col'>Notificacion Aplazada 5 Minutos</th>
																				<th scope='col'>Medicamento Tomado</th>
																			</tr>
																		</thead>
																		<tbody>";
																			$registroHorario=mysqli_query($this->obtenerConexion(),"SELECT * FROM notificacionMedicina WHERE claveMedicina = '$clave_med'");
																			$num = mysqli_num_rows($registroHorario);
																			for($i = 1;$i <= $num ;$i++){	
																			while($regHorario=mysqli_fetch_array($registroHorario)){
																				

																				$fechatoma=$regHorario['fecha_toma'];
																				$fecha_aplazada=$regHorario['fecha_aplazada'];
																				$med_tomado=$regHorario['med_tomado'];
																				echo "<tr>";
																				
																				echo "<th scope='row'>";
																		
																				echo $i++;
																			
																				echo "</th>";	
																				
																				echo "<td>".$regHorario['fecha_toma']."</td> ";
																				echo "<td>";
																				if($regHorario['fecha_aplazada'] == 1){echo "No aplazada";}else if($regHorario['fecha_aplazada'] == 2){echo "Aplazada";}
																				echo "</td> ";
																				echo "<td>";
																				if($regHorario['med_tomado'] == 1){echo "No Tomado";}else if($regHorario['med_tomado'] == 2){echo "Tomado";}

																				
																				echo "</td> </tr>";
																			}
																			}
																	echo "</tbody>
																	</table>
																</div>
															</div>
															<div class='col-lg-6 col-md-6 col-sm-12'>
																<h1 class='modal-title fs-5' id='exampleModalLabel'>Numero de Cita</h1>

																<div class='container-fluid marketing py-5'>
																	<table class='table'>
																		<thead>
																			<tr>
																				<th scope='col'>Numero de Cita</th>
																				<th scope='col'>Fecha de la Cita</th>
																				<th scope='col'></th>

																				
																			</tr>
																		</thead>
																		<tbody>";
																			$registroHorariocita=mysqli_query($this->obtenerConexion(),"SELECT * FROM citatratamiento WHERE claveMedicina = '$clave_med'");
																			
																			while($regHorariocita=mysqli_fetch_array($registroHorariocita)){
																				$idnumcita=$regHorariocita['idcitaTratamiento'];

																				 
																				$fechahorcita=$regHorariocita['fecha_citaTratamiento'];
																				$numcita=$regHorariocita['numeroCita'];
																				echo "<tr>
																				<th scope='row'>".$numcita."</th>";	
																				
																				echo "<td>".$fechahorcita."</td> ";
																				echo "<td>";
																				echo "<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
																				<input type='hidden' name='opc' value='24'>
																				<input type='hidden' name='clavecitamed' value=".$idnumcita.">
																				<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
																				</form>";
																				echo "</td>";
																				
																				echo "</tr>";
																			}
																			
																	echo "</tbody>
																	</table>
																</div>

															</div>
														</div>
													</div>
												</div>
											</div>

											<button type='button' class='btn btn-outline-primary mt-3' data-bs-toggle='modal' 
											data-bs-target='#exampleModalagregarcitaTratamiento".$reg['clave_med']."' data-bs-whatever='@mdo'>Registrar # de Cita</button>
											<div class='modal fade' id='exampleModalagregarcitaTratamiento".$reg['clave_med']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
												<div class='modal-dialog modal-xl'>
													<div class='modal-content'>
														<div class='modal-header'>
															<h1 class='modal-title fs-5' id='exampleModalLabel'>Agregar Numero de cita del Tratamiento</h1>
															<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
														</div>

														<div class='modal-body d-flex align-item-center justify-content-center'>
													
											
														<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data'> 

															
															
															<div class='mb-3'>
																<label  class='col-form-label'>Numero de Cita</label>
																<input type='number' class='form-control'   name='numerocita'>
															</div>

															<input type='hidden' name='clave_med' value='".$reg["clave_med"]."'>
															
															<input type='hidden' name='opc' value='23'>


															<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
															<button type='submit' class='btn btn-primary'>Agregar</button>
															
															</div>
														</form>
														
													</div>
													</div>
												</div>
											</div>

										</div>

									</div>

									<div class='col-lg-6 col-md-6 col-sm-12 '>
										<p>Indicaciones: <br>".$reg['indicacion_med']."</p>
									</div>
								</div>
								<hr>
								<div class='container d-flex justify-content-evenly'>
									<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#exampleModalModificar".$reg['clave_med']."' data-bs-whatever='@mdo'>Modificar</button>
									<div class='modal fade' id='exampleModalModificar".$reg['clave_med']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
											<div class='modal-dialog '>
												<div class='modal-content'>
													<div class='modal-header'>
														<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Medicamento</h1>
														<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
													</div>

													<div class='modal-body d-flex align-item-center justify-content-center'>
													
											
														<form action='./model/modificarMed2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModificarTratamiento(".$reg['clave_med'].");'> 

															<div class='mb-3'>
																<label for='nombre_med".$reg['clave_med']."' class='col-form-label'>Nombre del medicamento</label>
																<select class='form-select' name='nombre_med' id='nombre_med".$reg['clave_med']."'>"; 
																	$registrome=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicina");
																	echo "<option value='".$reg['idmedicina']."'>Selecciona el Medicamento</option>";
																	while ($regme=mysqli_fetch_array($registrome)){	
																		echo "<option value='$regme[0]'>$regme[1]</option>";
																	} 
																	echo "
																</select>
															</div>

															<div class='mb-3'> 
																<label class='col-form-label' for='forma_med".$reg['clave_med']."'>Forma Medica</label>
																<select class='form-select' name='forma_med' id='forma_med".$reg['clave_med']."'>"; 
																	$registrofm=mysqli_query($this->obtenerConexion(),"SELECT * FROM formamedica");
																	echo "<option value='".$reg['idformaMedica']."'>Selecciona la Forma Medica</option>";
																	while ($refm=mysqli_fetch_array($registrofm)){	
																		echo "<option value='$refm[0]'>$refm[1]</option>";
																	} echo "
																</select>
															</div>

															<div class='mb-3'>
																<label for='dosis_med".$reg['clave_med']."' class='col-form-label' >Dosis Medica</label>
																<input type='text' class='form-control' id='dosis_med".$reg['clave_med']."'   name='dosis_med' value='".$reg["dosis_med"]."'>
															</div>

															<div class='mb-3'>
																<label  class='col-form-label' for='via_med".$reg['clave_med']."'>Via de ingesta</label>
																<select class='form-select' name='via_med' id='via_med".$reg['clave_med']."'>"; 
																	$registrovm=mysqli_query($this->obtenerConexion(),"SELECT * FROM viamedica");
																	echo "<option value='".$reg['idviaMedica']."'>Selecciona la Via de Administracion</option>";
																	while ($revm=mysqli_fetch_array($registrovm)){	
																		echo "<option value='$revm[0]'>$revm[1]</option>";
																	} echo "
																</select>
															</div>

															<div class='mb-3'>
																<label  class='col-form-label' for='fre_med".$reg['clave_med']."'>Cada cuantas horas se tomara</label>
																<input type='number' class='form-control' id='fre_med".$reg['clave_med']."' name='fre_med' value='".$reg["fre_med"]."'>
															</div>
															
															<div class='mb-3'>
																<label  class='col-form-label' for='duracion_med".$reg['clave_med']."'>Cuantos dias durara el tratamiento</label>
																<input type='number' class='form-control' id='duracion_med".$reg['clave_med']."' name='duracion_med' value='".$reg["duracion_med"]."'>
															</div>

															<div class='mb-3'>
																<label  class='col-form-label' for='fecha_med".$reg['clave_med']."'>Fecha y Hora de Inicio del medicamento</label>
																<input type='datetime-local' class='form-control' id='fecha_med".$reg['clave_med']."'   name='fecha_med' value='".$reg["fecha_med"]."'>
															</div>

															<div class='mb-3'>
																<label  class='col-form-label' for='indicacion_med".$reg['clave_med']."'>Indicaciones de toma del Medicamento</label>
																<textarea class='form-control'  name='indicacion_med' id='indicacion_med".$reg['clave_med']."' value='".$reg['indicacion_med']."'>".$reg['indicacion_med']."</textarea>
															</div>
															<input type='hidden' name='clave_med' value='".$reg["clave_med"]."'>
															<input type='hidden' name='correo_us' value=".$correo.">
															<input type='hidden' name='clave_doc' value=".$clave_doc.">


															<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
															<button type='submit' class='btn btn-primary'>Modificar</button>
															
															</div>
														</form>
														
													</div>
												</div>
											</div>
											
									</div>
									<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
									<input type='hidden' name='opc' value='7'>
									<input type='hidden' name='clave_med' value=".$reg['clave_med'].">
									<input type='hidden' name='correo_us' value=".$correo.">
									<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
									</form>
								</div>
							</div>
						</div>	
					</div>
				</div>";
		}
	}
	//Borrar Medicamentos
	public function borrarMedicamento($clave_med,$correo_paciente){
		
		$clave=mysqli_query($this->obtenerConexion(),"select clave_us from usuarios where correo_us='$correo_paciente'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];
		mysqli_query($this->obtenerConexion(),"
		
		DELETE N               
		FROM notificacionMedicina N
		INNER JOIN medicamentos M ON M.clave_med = N.claveMedicina
		INNER JOIN usuarios U ON U.clave_us = M.Usuarios_clave_us
		WHERE M.Usuarios_clave_us ='$clave_us' 
		AND N.claveMedicina ='$clave_med' ");
		mysqli_query($this->obtenerConexion(),"delete from citatratamiento where claveMedicina='$clave_med'");


		mysqli_query($this->obtenerConexion(),"delete from medicamentos where clave_med='$clave_med'");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
			header("location: ../index.php?pagina=perfilDoctor");
			}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
				header("location: ../index.php?pagina=perfilAdmin");
			}
	}
	//Agregar cita tratamiento
	public function agregarcitaTratamiento($numcita,$clavemed) {
		$consulta = mysqli_query($this->obtenerConexion(),"SELECT * FROM citatratamiento WHERE numeroCita ='$numcita' AND claveMedicina = '$clavemed'");
		if($reg=mysqli_fetch_array($consulta)){
			if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
				echo'<script type="text/javascript">
		alert("Numero de Cita ya registrada");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
			}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
				echo'<script type="text/javascript">
		alert("Numero de Cita ya registrada");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';		
			}
		

		}else{
		mysqli_query($this->obtenerConexion(),"INSERT INTO citatratamiento(fecha_citaTratamiento,numeroCita,claveMedicina) VALUES (NOW(),'$numcita','$clavemed') ");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
			echo'<script type="text/javascript">
		alert("Cita del tratamiento registrada");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
			echo'<script type="text/javascript">
		alert("Cita del tratamiento registrada");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';			
		}
		
		}

		
	}
	//Eliminar cita tratamiento
	public function eliminarcitaMed($clavecitamed){
		mysqli_query($this->obtenerConexion(),"DELETE FROM citatratamiento WHERE idcitaTratamiento  = '$clavecitamed'");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
			echo '<script type="text/javascript">
			alert("Cita de Tratamiento Eliminada");
			window.location.href="../index.php?pagina=perfilDoctor";
			</script>';
		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
			echo '<script type="text/javascript">
			alert("Cita de Tratamiento Eliminada");
			window.location.href="../index.php?pagina=perfilAdmin";
			</script>';			
		}
		

	}
	/*-------------------MEDICINA--------------------*/
	public function VerMedicamentos(){
		$registros=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicina");
		while($reg=mysqli_fetch_array($registros)){
			$idMedicina = $reg['idmedicina'];
			$nombreMedicina = $reg['nombre_med'];
			$descripcionMedicina = $reg['descripcion_med'];	
			echo "
			
				<div class='col-sm-6 mb-2 mt-2 '>
					<div class='card'>
						<div class='card-body'>
						<h5 class='card-title'>ID :".$idMedicina."</h5>
						<h5 class='card-title'>Nombre del Medicamento : ".$nombreMedicina."</h5>
						<p class='card-text'>".$descripcionMedicina."</p>
						<hr>
						<div class='container d-flex justify-content-evenly'>

							<button type='button' class='btn btn-outline-primary'  
							data-bs-toggle='modal' data-bs-target='#exampleModalModificar' data-bs-whatever='@mdo'>Modificar</button>
									
							<div class='modal fade' id='exampleModalModificar' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Medicamento</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
										
													<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModificarMedicina(".$idMedicina.");'> 

														<div class='mb-3'>
															<label class='col-form-label' for='nombre_med".$idMedicina."'>Nombre del medicamento</label>
															<input type='text' class='form-control' id='nombre_med".$idMedicina."'  name='nombre_med'  value='".$nombreMedicina."'>
														</div>

														<div class='mb-3'>
															<label  class='col-form-label' for='descripcion_med".$idMedicina."'>Indicaciones de toma del Medicamento</label>
															<textarea class='form-control'  name='descripcion_med' id='descripcion_med".$idMedicina."' value='".$descripcionMedicina."'>".$descripcionMedicina."</textarea>
														</div>
														<input type='hidden' name='clave_med' value='".$idMedicina."'>
														<input type='hidden' name='opc' value='11'>

														<div class='modal-footer'>
														<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														<button type='submit' class='btn btn-primary'>Modificar</button>
														
														</div>
													</form>
													
												</div>
											</div>
										</div>
										
							</div>
									
							<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
							<input type='hidden' name='opc' value='12'>
							<input type='hidden' name='clave_med' value='".$idMedicina."'>
							<button class='btn btn-outline-danger'  type='submit'>Eliminar</button>
							</form>
						</div>
						</div>
					</div>
				</div>";

		}
	}
	public function ModificarMedicina($nombreMed,$descripcion,$idmed){
		mysqli_query($this->obtenerConexion(),"UPDATE medicina SET nombre_med = '$nombreMed',descripcion_med = '$descripcion' WHERE idmedicina='$idmed'");
		echo '<script type="text/javascript">
		alert("Medicina Modificada");
		window.location.href="../index.php?pagina=medicamentoRegistrado";
		</script>';
	}
	public function eliminarMedicina($idmed){
		mysqli_query($this->obtenerConexion(),"DELETE FROM medicina WHERE idmedicina = '$idmed'");
		echo '<script type="text/javascript">
		alert("Medicina Eliminada");
		window.location.href="../index.php?pagina=medicamentoRegistrado";
		</script>';
	}
	public function AgregarMedicina($nombreMed,$descripcion){
		$consulta = mysqli_query($this->obtenerConexion(),"SELECT * FROM medicina WHERE nombre_med ='$nombreMed'");
		if($reg=mysqli_fetch_array($consulta)){
			echo'<script type="text/javascript">
		alert("El medicamento ya se encuentra registrado");
		window.location.href="../index.php?pagina=medicamentoRegistrado";
		</script>';

		}else{
		mysqli_query($this->obtenerConexion(),"INSERT INTO medicina(nombre_med,descripcion_med) VALUES ('$nombreMed','$descripcion') ");
		echo'<script type="text/javascript">
		alert("Medicamento Registrado");
		window.location.href="../index.php?pagina=medicamentoRegistrado";
		</script>';
		}

	}
	/*-------------------VIAS--------------------*/
	public function VerVias(){
		$registros=mysqli_query($this->obtenerConexion(),"SELECT * FROM viamedica");
		while($reg=mysqli_fetch_array($registros)){
			$idVia = $reg['idviaMedica'];
			$viaMedicina = $reg['via_med'];
			echo "
			
				<div class='col-sm-6 mb-2 mt-2 '>
					<div class='card'>
						<div class='card-body'>
						<h5 class='card-title'>ID :".$idVia."</h5>
						<h5 class='card-title'>Via de Administracion : ".$viaMedicina."</h5>						<hr>
						<div class='container d-flex justify-content-evenly'>

							<button type='button' class='btn btn-outline-primary'  
							data-bs-toggle='modal' data-bs-target='#exampleModalModificarVia".$idVia."' data-bs-whatever='@mdo'>Modificar</button>
									
							<div class='modal fade' id='exampleModalModificarVia".$idVia."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Via de Administracion</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
										
													<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModificarVia(".$idVia.");'> 

														<div class='mb-3'>
															<label class='col-form-label' for='viamed".$idVia."' for='viamed'>Nombre del medicamento</label>
															<input type='text' class='form-control' id='viamed".$idVia."' name='viamed'  value='".$viaMedicina."'>
														</div>

														
														<input type='hidden' name='idvia' value='".$idVia."'>
														<input type='hidden' name='opc' value='14'>

														<div class='modal-footer'>
														<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														<button type='submit' class='btn btn-primary'>Modificar</button>
														
														</div>
													</form>
													
												</div>
											</div>
										</div>
										
							</div>
									
							<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
							<input type='hidden' name='opc' value='15'>
							<input type='hidden' name='idvia' value='".$idVia."'>
							<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
							</form>
						</div>
						</div>
					</div>
				</div>";

		}
	}
	public function ModificarVias($viamed,$idvia){
		mysqli_query($this->obtenerConexion(),"UPDATE viamedica SET via_med = '$viamed' WHERE idviaMedica='$idvia'");
		echo '<script type="text/javascript">
		alert("Via Modificada");
		window.location.href="../index.php?pagina=viasConsumo";
		</script>';
	}
	public function eliminarVias($idvia){
		mysqli_query($this->obtenerConexion(),"DELETE FROM viamedica WHERE idviaMedica = '$idvia'");
		echo '<script type="text/javascript">
		alert("Via Eliminada");
		window.location.href="../index.php?pagina=viasConsumo";
		</script>';
	}
	public function AgregarVias($viamed){
		$consulta = mysqli_query($this->obtenerConexion(),"SELECT * FROM viamedica WHERE via_med ='$viamed'");
		if($reg=mysqli_fetch_array($consulta)){
			echo'<script type="text/javascript">
		alert("La via de Adminsitracion ya se encuentra registrada");
		window.location.href="../index.php?pagina=viasConsumo";
		</script>';

		}else{
		mysqli_query($this->obtenerConexion(),"INSERT INTO viamedica(via_med) VALUES ('$viamed') ");
		echo'<script type="text/javascript">
		alert("Via de administracion Registrado");
		window.location.href="../index.php?pagina=viasConsumo";
		</script>';
		}

	}
	/*-------------------VIAS--------------------*/
	public function VerForma(){
		$registros=mysqli_query($this->obtenerConexion(),"SELECT * FROM formamedica");
		while($reg=mysqli_fetch_array($registros)){
			$idforma = $reg['idformaMedica'];
			$formaMedicina = $reg['forma_medicina'];
			echo "
			
				<div class='col-sm-6 mb-2 mt-2 '>
					<div class='card'>
						<div class='card-body'>
						<h5 class='card-title'>ID :".$idforma."</h5>
						<h5 class='card-title'>Forma Medica : ".$formaMedicina."</h5>
						<hr>
						<div class='container d-flex justify-content-evenly'>

							<button type='button' class='btn btn-outline-primary'  
							data-bs-toggle='modal' data-bs-target='#exampleModalModforma".$idforma."' data-bs-whatever='@mdo'>Modificar</button>
									
							<div class='modal fade' id='exampleModalModforma".$idforma."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Forma Medica</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
										
												<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModificarFormas(".$idforma.");'> 

														<div class='mb-3'>
															<label class='col-form-label' for='formamed".$idforma."'>Nombre de la Forma Medica</label>
															<input type='text' class='form-control' id='formamed".$idforma."' name='formamed'  value='".$formaMedicina."'>
														</div>

														
														<input type='hidden' name='idforma'  value='".$idforma."'>
														<input type='hidden' name='opc' value='17'>

														<div class='modal-footer'>
														<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														<button type='submit' class='btn btn-primary'>Modificar</button>
														
														</div>
													</form>
													
												</div>
											</div>
										</div>
										
							</div>
									
							<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
							<input type='hidden' name='opc' value='18'>
							<input type='hidden' name='idforma' value='".$idforma."'>
							<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
							</form>
						</div>
						</div>
					</div>
				</div>";

		}
	}
	public function ModificarForma($idforma,$formaMed){
		mysqli_query($this->obtenerConexion(),"UPDATE formamedica SET forma_medicina = '$formaMed' WHERE idformaMedica ='$idforma'");
		echo '<script type="text/javascript">
		alert("Forma Medica Modificada");
		window.location.href="../index.php?pagina=formasMedicas";
		</script>';
	}
	public function eliminarForma($idforma){
		mysqli_query($this->obtenerConexion(),"DELETE FROM formamedica WHERE idformaMedica  = '$idforma'");
		echo '<script type="text/javascript">
		alert("Forma Medica Eliminada");
		window.location.href="../index.php?pagina=formasMedicas";
		</script>';
	}
	public function AgregarFormaMed($formaMed){
		$consulta = mysqli_query($this->obtenerConexion(),"SELECT * FROM formamedica WHERE forma_medicina ='$formaMed'");
		if($reg=mysqli_fetch_array($consulta)){
			echo'<script type="text/javascript">
		alert("La forma Medica ya se encuentra registrada");
		window.location.href="../index.php?pagina=formasMedicas";
		</script>';

		}else{
		mysqli_query($this->obtenerConexion(),"INSERT INTO formamedica(forma_medicina) VALUES ('$formaMed') ");
		echo'<script type="text/javascript">
		alert("Forma Medica Registrada");
		window.location.href="../index.php?pagina=formasMedicas";
		</script>';
		}

	}
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-------------------CITAS-----------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	//Formulario Cita
	
	//Agregar Cita
	public function AgregarCita($fecha_cita,$lugar_cita,$indi_cita,$clave_us,$clave_doc){

		echo $clave_doc;
		$connCita = $this->obtenerConexion();
		$idCitaa="";
		if($_SESSION['tipoUs'] == 2){
			$insertarCita = "INSERT INTO cita(fecha_cita,lugar_cita,indi_cita,Usuarios_clave_us,iddoctor,claveAdmin) VALUES 
		('$fecha_cita','$lugar_cita','$indi_cita','$clave_us','$clave_doc',NULL)";
		$connCita->query($insertarCita);
		$idCitaa = $connCita->insert_id;
		}else if($_SESSION['tipoUs'] == 3){

			$insertarCita = "INSERT INTO cita(fecha_cita,lugar_cita,indi_cita,Usuarios_clave_us,iddoctor,claveAdmin) VALUES 
		('$fecha_cita','$lugar_cita','$indi_cita','$clave_us',NULL,'$clave_doc')";

		$connCita->query($insertarCita);
		$idCitaa = $connCita->insert_id;
		}
		
		/*echo '<script type="text/javascript">
        alert("Cita Registrada");
        window.location.href="../CtrlUsuario/perfil.php";
        </script>';*/






		date_default_timezone_set('America/Mexico_City');
		$fechaActualCita = date("Y/m/d G:i:s");
		$registroCita=mysqli_query($this->obtenerConexion(),"SELECT * FROM cita where Usuarios_clave_us='$clave_us' AND clave_cita='$idCitaa'");

		while($registroCitas=mysqli_fetch_array($registroCita)){
			$fechaCreadaCita = date_create($registroCitas['fecha_cita']);
			$fechaInicioCita = date_format($fechaCreadaCita,'Y/m/d G:i:s');
			//echo $fechaInicioCita."<br>";
			$claveCita=$registroCitas["clave_cita"];

			$restaFechaFinalCita = strtotime($fechaInicioCita."- 1 days");
			$fechaFinalCita=date("Y/m/d G:i:s",$restaFechaFinalCita);
			//echo $fechaFinalCita;
			
			$consultaCita=mysqli_query($this->obtenerConexion(),"SELECT  *                
			FROM notificacionCitas N
			WHERE N.fecha_cita ='$fechaFinalCita'
			ORDER BY N.fecha_cita ASC");

			if($registCita=mysqli_fetch_array($consultaCita)){}else{
				mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionCitas(idnotificacionCitas,fecha_cita,claveCita) VALUES 
					(NULL,'$fechaFinalCita','$claveCita')");
			}
			

			$segundosFechaInicioCita=strtotime($fechaFinalCita);
			$segundosFechaFinalCita=strtotime($fechaInicioCita);
			$segundosDeDirenciaCita= $segundosFechaFinalCita - $segundosFechaInicioCita;
			$minutosCita = $segundosDeDirenciaCita/60;
			
			$horasCita = $minutosCita/60;
			//echo $horasCita."<br>";
			$diaCita = $horasCita/24;
			$sumaCita=0;
			for($i=0;$i<=$horasCita;$i++){
				$sumaCita+=4;
				if($sumaCita<$horasCita){
				$mo_dateCita = strtotime($fechaFinalCita."+".$sumaCita." hours");
				$tomaCita=date("Y/m/d G:i:s",$mo_dateCita);
				//echo $tomaCita."<br>";

				$consultaCita2=mysqli_query($this->obtenerConexion(),"SELECT  *                
				FROM notificacionCitas N
				WHERE N.fecha_cita ='$tomaCita'
				ORDER BY N.fecha_cita ASC");
				if($registCita2=mysqli_fetch_array($consultaCita2)){}else{
					mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionCitas(idnotificacionCitas,fecha_cita,claveCita) VALUES 
				(NULL,'$tomaCita','$claveCita')");
				}
				
				}
			}
		}


		if($_SESSION['tipoUs'] == 2){
			echo'<script type="text/javascript">
		alert("Cita registrada");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
		}else if($_SESSION['tipoUs'] == 3){
			echo'<script type="text/javascript">
		alert("Cita registrada");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';
		}
	}
	//Mostrar Cita
	public function MostrarCita(){
		$correo = $_SESSION['usuario'];
		$tipous = $_SESSION['tipoUs'];
		$clave = mysqli_query($this->obtenerConexion(),"select clave_us from usuarios where correo_us='$correo' AND tipoUsuario ='$tipous'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];

		date_default_timezone_set('America/Mexico_City');
		$fechaActualCita = date("Y/m/d G:i:s");
		$registroCita=mysqli_query($this->obtenerConexion(),"SELECT * FROM cita where Usuarios_clave_us='$clave_us'");

		while($registroCitas=mysqli_fetch_array($registroCita)){
			echo "
			
				<div class='accordion' id='accordionExample".$registroCitas['clave_cita']."'>
					<div class='accordion-item'>

						<h2 class='accordion-header'>
							<button  class='btn collapsed w-100 text-white' style='
							
							background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,152,155,1) 0.1%, rgba(0,94,120,1) 94.2% );							
							border-color:linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo".$registroCitas['clave_cita']."' aria-expanded='false' aria-controls='collapseTwo'>
							<p>Lugar de la Cita : ".$registroCitas['lugar_cita']."</p>
							<p>Fecha de Cita : ".$registroCitas['fecha_cita']."</p>
							</button>
						</h2>

						<div id='collapseTwo".$registroCitas['clave_cita']."' class='accordion-collapse collapse' data-bs-parent='#accordionExample".$registroCitas['clave_cita']."'>
							<div class='accordion-body'>
								<p>Indicaciones de Cita\n".$registroCitas['indi_cita']."</p>

								

								
								
							</div>
						</div>	
					</div>
				</div>
			";			
		}
		echo "";
		
	}
	public function MostrarCitaDoctor($correo,$clave_doc){
		
		$clave = mysqli_query($this->obtenerConexion(),"select clave_us from usuarios where correo_us='$correo'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];

		date_default_timezone_set('America/Mexico_City');
		$fechaActualCita = date("Y/m/d G:i:s");
		$registroCita=mysqli_query($this->obtenerConexion(),"SELECT * FROM cita where Usuarios_clave_us='$clave_us'");

		while($registroCitas=mysqli_fetch_array($registroCita)){
			$fechaCreadaCita = date_create($registroCitas['fecha_cita']);
			$fechaInicioCita = date_format($fechaCreadaCita,'Y/m/d G:i:s');
			//echo $fechaInicioCita."<br>";
			$claveCita=$registroCitas["clave_cita"];

			$restaFechaFinalCita = strtotime($fechaInicioCita."- 1 days");
			$fechaFinalCita=date("Y/m/d G:i:s",$restaFechaFinalCita);
			//echo $fechaFinalCita;
			
			

			$segundosFechaInicioCita=strtotime($fechaFinalCita);
			$segundosFechaFinalCita=strtotime($fechaInicioCita);
			$segundosDeDirenciaCita= $segundosFechaFinalCita - $segundosFechaInicioCita;
			$minutosCita = $segundosDeDirenciaCita/60;
			
			$horasCita = $minutosCita/60;
			//echo $horasCita."<br>";
			$diaCita = $horasCita/24;
			$sumaCita=0;
			for($i=0;$i<=$horasCita;$i++){
				$sumaCita+=4;
				if($sumaCita<$horasCita){
				$mo_dateCita = strtotime($fechaFinalCita."+".$sumaCita." hours");
				$tomaCita=date("Y/m/d G:i:s",$mo_dateCita);
				//echo $tomaCita."<br>";

				
				
				}
			}

			echo "
			
				<div class='accordion' id='accordionExample".$registroCitas['clave_cita']."'>
					<div class='accordion-item'>

						<h2 class='accordion-header'>
							<button  class='btn collapsed w-100 text-white' style='
							
							background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,152,155,1) 0.1%, rgba(0,94,120,1) 94.2% );							
							border-color:linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo".$registroCitas['clave_cita']."' aria-expanded='false' aria-controls='collapseTwo'>
							<p>Lugar de la Cita : ".$registroCitas['lugar_cita']."</p>
							<p>Fecha de Cita : ".$registroCitas['fecha_cita']."</p>
							</button>
						</h2>

						<div id='collapseTwo".$registroCitas['clave_cita']."' class='accordion-collapse collapse' data-bs-parent='#accordionExample".$registroCitas['clave_cita']."'>
							<div class='accordion-body'>
								<p>Indicaciones de Cita\n".$registroCitas['indi_cita']."</p>

								<div class='container d-flex justify-content-evenly'>

									<button type='button' class='btn btn-outline-primary'  
									data-bs-toggle='modal' data-bs-target='#exampleModalModCita".$registroCitas['clave_cita']."' data-bs-whatever='@mdo'>Modificar</button>
									<div class='modal fade' id='exampleModalModCita".$registroCitas['clave_cita']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Cita</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
												<form  action='./model/modificarCita2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModificarCita(".$registroCitas['clave_cita'].");'> 

														<div class='mb-3'>
															<label  class='col-form-label' for='lugar_cita".$registroCitas['clave_cita']."'>Lugar de la cita</label>
															<input type='text' class='form-control' id='lugar_cita".$registroCitas['clave_cita']."'  name='lugar_cita' value='".$registroCitas['lugar_cita']."'>
														</div>

														<div class='mb-3'>
															<label  class='col-form-label' for='fecha_cita".$registroCitas['clave_cita']."'>Fecha y Hora de la Cita</label>
															<input type='datetime-local' class='form-control' id='fecha_cita".$registroCitas['clave_cita']."'  name='fecha_cita' value='".$registroCitas['fecha_cita']."'>
														</div>

														<div class='mb-3'>
															<label  class='col-form-label' for='indi_cita".$registroCitas['clave_cita']."'>Indicaciones de previas a la cita</label>
															<textarea class='form-control' id='indi_cita".$registroCitas['clave_cita']."'  name='indi_cita' value='".$registroCitas['indi_cita']."'>".$registroCitas['indi_cita']."</textarea>
														</div>
														<input type='hidden' name='clave_cita' value='".$registroCitas['clave_cita']."'>
														<input type='hidden' name='clave_doc' value='".$clave_doc."'>
														<input type='hidden' name='correo_us' value='".$correo."'>


														<hr>
													
														<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
															<button type='submit' class='btn btn-primary'>Modificar</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									
									<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
									<input type='hidden' name='opc' value='9'>
									<input type='hidden' name='clave_cita' value=".$registroCitas['clave_cita'].">
									<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
									</form>
								</div>

								
								
							</div>
						</div>	
					</div>
				</div>
			";

			
							
		}
		echo "";
		
	}
	//Modificar Cita
	public function modCita2($clave_cita,$fecha_cita,$lugar_cita,$indi_cita,$clave_doc,$correo_us){
		
		$clave=mysqli_query($this->obtenerConexion(),"select clave_us from usuarios where correo_us='$correo_us'");
		$reg_clave=mysqli_fetch_array($clave);
		$clave_us=$reg_clave['clave_us'];
		
		$consultaCita=mysqli_query($this->obtenerConexion(),"DELETE N                
			FROM notificacionCitas N
			WHERE N.claveCita='$clave_cita'");

		$registro=mysqli_query($this->obtenerConexion(),"UPDATE cita set fecha_cita='$fecha_cita',lugar_cita='$lugar_cita',indi_cita='$indi_cita',iddoctor='$clave_doc'
		where clave_cita='$clave_cita'");

		date_default_timezone_set('America/Mexico_City');
		$fechaActualCita = date("Y/m/d G:i:s");
		$registroCita=mysqli_query($this->obtenerConexion(),"SELECT * FROM cita where Usuarios_clave_us='$clave_us' and clave_cita='$clave_cita'");

		while($registroCitas=mysqli_fetch_array($registroCita)){
			$fechaCreadaCita = date_create($registroCitas['fecha_cita']);
			$fechaInicioCita = date_format($fechaCreadaCita,'Y/m/d G:i:s');
			//echo $fechaInicioCita."<br>";
			$claveCita=$registroCitas["clave_cita"];

			$restaFechaFinalCita = strtotime($fechaInicioCita."- 1 days");
			$fechaFinalCita=date("Y/m/d G:i:s",$restaFechaFinalCita);
			//echo $fechaFinalCita;
			
			$consultaCita=mysqli_query($this->obtenerConexion(),"SELECT  *                
			FROM notificacionCitas N
			WHERE N.fecha_cita ='$fechaFinalCita'
			ORDER BY N.fecha_cita ASC");

			if($registCita=mysqli_fetch_array($consultaCita)){}else{
				mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionCitas(idnotificacionCitas,fecha_cita,claveCita) VALUES 
					(NULL,'$fechaFinalCita','$claveCita')");
			}
			

			$segundosFechaInicioCita=strtotime($fechaFinalCita);
			$segundosFechaFinalCita=strtotime($fechaInicioCita);
			$segundosDeDirenciaCita= $segundosFechaFinalCita - $segundosFechaInicioCita;
			$minutosCita = $segundosDeDirenciaCita/60;
			
			$horasCita = $minutosCita/60;
			//echo $horasCita."<br>";
			$diaCita = $horasCita/24;
			$sumaCita=0;
			for($i=0;$i<=$horasCita;$i++){
				$sumaCita+=4;
				if($sumaCita<$horasCita){
				$mo_dateCita = strtotime($fechaFinalCita."+".$sumaCita." hours");
				$tomaCita=date("Y/m/d G:i:s",$mo_dateCita);
				//echo $tomaCita."<br>";

				$consultaCita2=mysqli_query($this->obtenerConexion(),"SELECT  *                
				FROM notificacionCitas N
				WHERE N.fecha_cita ='$tomaCita'
				ORDER BY N.fecha_cita ASC");
				if($registCita2=mysqli_fetch_array($consultaCita2)){}else{
					mysqli_query($this->obtenerConexion(),"INSERT INTO notificacionCitas(idnotificacionCitas,fecha_cita,claveCita) VALUES 
				(NULL,'$tomaCita','$claveCita')");
				}
				
				}
			}
		}
		if($_SESSION['tipoUs'] == 2){
			echo'<script type="text/javascript">
		alert("Tratamiento Modificado");
		window.location.href="../index.php?pagina=perfilDoctor";
		</script>';
		}else if($_SESSION['tipoUs'] == 3){
			echo'<script type="text/javascript">
		alert("Tratamiento Modificado");
		window.location.href="../index.php?pagina=perfilAdmin";
		</script>';
		}

		
	}
	//Borrar Medicamento
	public function borrarCita($clave_cita){
		mysqli_query($this->obtenerConexion(),"DELETE N                
			FROM notificacionCitas N
			WHERE N.claveCita='$clave_cita'");
		mysqli_query($this->obtenerConexion(),"delete from cita where clave_cita='$clave_cita'");		  
	}
	/*Command (comandoEliminarUsuario y ejecutarComando):
	comandoEliminarUsuario devuelve un objeto ComandoEliminarUsuario, 
	encapsulando la solicitud de eliminación en un objeto separado.
	ejecutarComando toma un objeto comando como parámetro y ejecuta 
	su método ejecutar. Esto desacopla el código cliente (donde se llama a ejecutarComando) 
	de los detalles específicos de la implementación del comando.*/
	//Borrar Cita con patron de diseño Command
	public function ejecutarComando($comando) {
        $comando->ejecutar($this->obtenerConexion());
    }
    // Comando para eliminar usuario
    public function comandoEliminarCita($idCita) {
		
        return new ComandoEliminarCita($idCita);
    }
	//Cerrar Sesion
	public function desconectar(){
		mysqli_close($this->obtenerConexion());
	}
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-------------------Doctor-----------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	public function PanelDoctorUsuarios(){
		$correo = $_SESSION['usuario'];
		$tipoUs = $_SESSION['tipoUs'];
		
		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor WHERE correo_doc='$correo' AND tipoUsuario='$tipoUs'");		
		while($reg=$registro->fetch_assoc()){
			echo "<div class='d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary' style='width: 280px;'>
			<a style ='cursor:pointer;' data-bs-toggle='modal' data-bs-target='#exampleModalPerfilDoctor".$reg['iddoctor'] ."' class='nav-link d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none'>
			  <svg class='bi pe-none me-2' width='40' height='32'><use xlink:href='#bootstrap'></use></svg>
			  <span class='fs-4'>Doctor ".$reg['nombre_doc'] ."</span>
			</a>
			<div class='modal fade' id='exampleModalPerfilDoctor".$reg['iddoctor'] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog modal-xl'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Perfil Doctor</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
													<div class='modal-body p-5 pt-0'>
														<div class='card text-center'>
															<div ass='card-header'>
															<img src='".$reg['foto_doc']."' class='' style='object-fit:contain;object-position:center;border-radius:500px;width:200px;height:200px;' alt='...'>

																<h5>Dr. ".$reg['nombre_doc']." ".$reg['apellidos_doc']."</h5>
															</div>
															<div class='card-body'>
															<p class='card-text'>Genero : ".$reg['genero_doc']."</p>
															<p class='card-text'>Telefono: ".$reg['telefono_doc']."</p>
															<p class='card-text'>Correo : ".$reg['correo_doc']."</p>

															</div>
															<div class='card-footer text-body-secondary'>
																Cedula Profesional : ".$reg['cedula_doc']." emitida por ".$reg['institucion']."
															</div>
														</div>
														<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														</div>        
												  
											  		</div>
												</div>
											</div>
										</div>
										
			</div>
			<hr>
			<ul class='nav nav-pills flex-column mb-auto'>
				<li>
				<a class='nav-link link-body-emphasis' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>Editar Perfil</a>
				<ul class='dropdown-menu'>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarDoctor".$reg['iddoctor'] ."'>Editar Datos</a></li>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarContraDoctor".$reg['iddoctor'] ."'>Editar Contraseña</a></li>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarFotoDoctor".$reg['iddoctor'] ."'>Editar Foto</a></li>
				</ul>
				
				<div class='modal fade' id='exampleModalModificarDoctor".$reg['iddoctor'] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Datos Doctor</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												<div class='modal-body p-5 pt-0'>
												<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModDatosDoctor();'>
												<div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='nombre_doc' name='nombre_doc' value='".$reg['nombre_doc']."'>
													<label for='nombre_doc'>Nombre(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='apellidos_doc' name='apellidos_doc' value='".$reg['apellidos_doc']."'>
													<label for='apellidos_doc'>Apellidos(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='telefono_doc' name='telefono_doc' value='".$reg['telefono_doc']."'>
													<label for='telefono_doc'>Telefono</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text'  class='form-control rounded-3' id='genero_doc' name='genero_doc' value='".$reg['genero_doc']."'>
													<label for='genero_doc'>Genero</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='cedula_doc' name='cedula_doc' value='".$reg['cedula_doc']."'>
													<label for='cedula_doc'>Cedula</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='institucion' name='institucion' value='".$reg['institucion']."'>
													<label for='institucion'>Institucion</label>
												  </div>
												  <input type='hidden' name='opc' value='19'>
												  <input type='hidden' name='iddoc' value='".$reg['iddoctor'] ."'>

												  <div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												  </div>        
												</form>    
											  </div>

												</div>
											</div>
										</div>
										
				</div>
				
				<div class='modal fade' id='exampleModalModificarFotoDoctor".$reg['iddoctor'] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Datos Doctor</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
												<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' class='d-flex align-items-center flex-column' onsubmit='return ValidacionModFotoDoctor();'> 
												<img class='img-form' src='".$reg["foto_doc"]."' width='100' height='100'>
														<div class='mb-3'>
															<label for='foto_doc' class='col-form-label'>Selecciona la Imagen</label>
															<input require type='file' id='foto_doc' name='foto_doc' >
															<input type='hidden' name='iddoctor' value='".$reg['iddoctor']."'>
															<input type='hidden' name='opc' value='21'>
														</div>
	
														
														
														<div class='modal-footer'>
														<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														<button type='submit' class='btn btn-primary'>Modificar</button>
														</div>
													</form>   
											  

												</div>
											</div>
										</div>
										
				</div>

				
				<div class='modal fade' id='exampleModalModificarContraDoctor".$reg['iddoctor'] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Datos Doctor</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												<div class='modal-body p-5 pt-0'>
												<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModContraDoctor();'> 
													<div class='mb-3'>
														<label for='contra_actual' class='col-form-label'>Contraseña Actual</label>
														<input type='password' id='contra_actual' name='contra_actual' class='form-control' autocomplete='on'>
													</div>
													<div class='mb-3'>
														<label for='contra_nueva' class='col-form-label'>Contraseña Nueva</label>
														<input type='password' id='contra_nueva' class='form-control' name='contrasena_doc' autocomplete='on'>
													</div>
													<div class='mb-3'>
														<label for='contra_repetida' class='col-form-label'>Repite la Contraseña</label>
														<input type='password' id='contra_repetida' class='form-control' autocomplete='on'>
													</div>	
													<input type='hidden' name='iddoctor' value='".$reg['iddoctor']."'>
													<input type='hidden' name='opc' value='22'>

										
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												</form>    
											  </div>

												</div>
											</div>
										</div>
										
				</div>

				</li>




			  
				
			




			  <li>
				<a href='#' class='nav-link link-body-emphasis' data-bs-toggle='modal' data-bs-target='#exampleModalRegistrarPaciente'>
				  Registrar Paciente
				</a>
				<div class='modal fade' id='exampleModalRegistrarPaciente' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Registrar Paciente</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
										
												<div class='modal-body p-5 pt-0'>
												<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionRegistroPaciente();'>
												<div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='nombre_us' name='nombre_us'>
													<label for='nombre_us'>Nombre(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='apellidos_us' name='apellidos_us' >
													<label for='apellidos_us'>Apellidos(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='telefono_us' name='telefono_us'>
													<label for='telefono_us'>Telefono</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='file'  class='form-control rounded-3' id='foto_us' name='foto_us' >
													<label for='foto_us'>Foto</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='correo_us' name='correo_us' >
													<label for='correo_us'>Correo</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='password' class='form-control rounded-3' id='contrasena_us' name='contrasena_us' >
													<label for='contrasena_us'>Contraseña</label>
												  </div>
												  <input type='hidden' name='opc' value='1'>
												  <div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												  </div>        
												</form>    
											  </div>

														
						
													
												</div>
											</div>
										</div>
										
				</div>
			
			  </li>
			  <li>
				<a href='./index.php?pagina=medicamentoRegistrado' class='nav-link link-body-emphasis'>
				  Medicamentos Registrados
				</a>
			  </li>
			  <li>
				<a href='./index.php?pagina=formasMedicas' class='d-flex nav-link link-body-emphasis'>
				  Formas Medicas Registradas
				</a>
			  </li>
			  <li>
				<a href='./index.php?pagina=viasConsumo' class='d-flex nav-link link-body-emphasis'>
				  Vias de Consumo Registradas
				</a>
			  </li>
			</ul>
			
		  </div>";
		}
	}
	public function listarUsuariosDoctor($correo){
		$correodoc = $_SESSION['usuario'];
		$tipous = $_SESSION['tipoUs'];
		$clave_doc ="";
		if($_SESSION['tipoUs'] == 2){
			$registroDoc=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor WHERE correo_doc='$correodoc' AND tipoUsuario = '$tipous'");
		$regDoc=mysqli_fetch_array($registroDoc);
		$clave_doc = $regDoc['iddoctor'];
		}else if($_SESSION['tipoUs'] == 3){
			$registroDoc=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us='$correodoc' AND tipoUsuario='$tipous'");
		$regDoc=mysqli_fetch_array($registroDoc);
		$clave_doc = $regDoc['clave_us'];
		}
		
		

	


		
		$registrouss=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us='$correo'");		
		while($reg=mysqli_fetch_array($registrouss)){
			$clave_usuario = $reg['clave_us'];
			$telefonous= $reg["telefono_us"];
			$apellidosus=$reg['apellidos_us'];
			$nombreus = $reg["nombre_us"];
			$fotous = $reg["foto_us"];
	
		//Perfil	
		echo "
		<div class='container marketing py-5'>
			<div class='text-center my-5'>
				<h1>Perfil</h1>
				<h3>ID de Usuario : ".$reg['clave_us']."</h3>
			</div>
			<div class='card' style='border:unset; align-items: center;'>
				<img src='".$reg['foto_us']."' class='' style='object-fit:contain;object-position:center;border-radius:500px;width:200px;height:200px;' alt='...'>
				<div class='card-body d-flex flex-column align-items-center ' style='width:100%;'>
      				<h5 class='card-title'>".$reg['nombre_us'] ."  ". $reg['apellidos_us']."</h5>
	  				<div class='card-body p-4 ' style='width:100%;'>
	  					<hr class='mt-0 mb-4'>
	  					<div class='row pt-1' style=''>
							<div class='col-6 mb-3' style='display:flex;flex-direction:column;align-items:center;'>
						    	<h6>Email</h6>
		  						<p class='text-muted'>".$reg['correo_us']."</p>
							</div>
							<div class='col-6 mb-3' style='display:flex;flex-direction:column;align-items: center;'>
								<h6>Phone</h6>
								<p class='text-muted'>".$reg['telefono_us']."</p>
							</div>
	  					</div>
	 				</div> 
    			</div>
			</div>
			

			<ul class='nav justify-content-evenly'>

				<button class='btn btn-outline-primary mt-2' style='--bs-btn-color: #000000;' data-bs-toggle='modal' data-bs-target='#exampleModal1'>Registrar Medicamento</button>
				<div class='modal fade' id='exampleModal1' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						<div class='modal-dialog '>
							<div class='modal-content'>
								<div class='modal-header'>
									<h1 class='modal-title fs-5' id='exampleModalLabel'>Registrar Medicamento</h1>
									<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
								</div>
								<div class='modal-body d-flex align-item-center justify-content-center'>
									<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionRegistroTratamiento();'> 

										<div class='mb-3'>
											<label for='nombre_med' class='col-form-label'>Nombre del medicamento</label>
											<select class='form-select' name='nombre_med' id='nombre_med'>
											"; $registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicina");

											while ($reg=mysqli_fetch_array($registro)){	
												echo "<option value='$reg[0]'>$reg[1]</option>";
											} echo "
											</select>
										</div>

										<div class='mb-3'>
											<label for='forma_med' class='col-form-label'>Forma Medica</label>
											<select class='form-select' name='forma_med' id='forma_med'>
											"; $registro1=mysqli_query($this->obtenerConexion(),"SELECT * FROM formamedica");

											while ($reg=mysqli_fetch_array($registro1)){	
												echo "<option value='$reg[0]'>$reg[1]</option>";
											} echo "
											</select>
										</div>

										<div class='mb-3'>
											<label for='dosis_med' class='col-form-label'>Dosis Medica</label>
											<input type='text' class='form-control' id='dosis_med' name='dosis_med'>
										</div>

										<div class='mb-3'>
											<label for='via_med' class='col-form-label'>Via de ingesta</label>
											<select class='form-select' name='via_med' id='via_med'>
											"; $registro2=mysqli_query($this->obtenerConexion(),"SELECT * FROM viamedica");

											while ($reg=mysqli_fetch_array($registro2)){	
												echo "<option value='$reg[0]'>$reg[1]</option>";
											} echo "
											</select>
										</div>

										<div class='mb-3'>
											<label for='fre_med' class='col-form-label'>Cada cuantas horas se tomara</label>
											<input type='number' class='form-control' id='fre_med' name='fre_med'>
										</div>
										
										<div class='mb-3'>
											<label for='duracion_med' class='col-form-label'>Cuantos dias durara el tratamiento</label>
											<input type='number' class='form-control' id='duracion_med' name='duracion_med'>
										</div>

										<div class='mb-3'>
											<label for='fecha_med' class='col-form-label'>Fecha y Hora de Inicio del medicamento</label>
											<input type='datetime-local' class='form-control' id='fecha_med' name='fecha_med'>
										</div>

										<div class='mb-3'>
											<label for='indicacion_med' class='col-form-label'>Indicaciones de toma del Medicamento</label>
											<textarea class='form-control' id='indicacion_med'  name='indicacion_med'></textarea>
										</div>
										<input type='hidden' name='opc' value='6'>
										<input type='hidden' name='clave_us' value='".$clave_usuario."'>
										<input type='hidden' name='clave_doc' value='".$clave_doc."'>

										<div class='modal-footer'>
										<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
										<button type='submit' class='btn btn-primary'>Registrar</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				

				<li class=' btn btn-outline-primary mt-2' style='padding:0;display:flex;width:162px;height:48px;align-items:center;justify-content:center;'>
					<a class=' dropdown-toggle btn ' style='width: 100%;
					height: 100%;
					padding: 0;
					display: flex;
					align-items: center;
					justify-content: center;' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>Editar Perfil</a>
					<ul class='dropdown-menu'>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal3'>Editar Datos</a></li>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal5'>Editar Contraseña</a></li>
						<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModal4'>Editar Foto</a></li>
					</ul>
				</li>

				<button class='btn btn-outline-primary mt-2' style='--bs-btn-color: #000000;width: 162px;height: 48px;' data-bs-toggle='modal' data-bs-target='#exampleModal2'>Registrar Citas</button>
					<div class='modal fade' id='exampleModal2' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Registrar Cita</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body'>
												<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionRegistroCita();'>

													<div class='mb-3'>
														<label for='lugar_cita' class='col-form-label'>Lugar de la cita</label>
														<input type='text' class='form-control' id='lugar_cita' name='lugar_cita'>
													</div>

													<div class='mb-3'>
														<label for='fecha_cita' class='col-form-label'>Fecha y Hora de la Cita</label>
														<input type='datetime-local' class='form-control' id='fecha_cita'  name='fecha_cita'>
													</div>

													<div class='mb-3'>
														<label for='indi_cita' class='col-form-label'>Indicaciones de previas a la cita</label>
														<textarea class='form-control' id='indi_cita'  name='indi_cita'></textarea>
													</div>
													<input type='hidden' name='opc' value='8'>
													<input type='hidden' name='clave_us' value='".$clave_usuario."'>
													<input type='hidden' name='id_doctor' value='".$clave_doc."'>

													

												
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Registrar</button>
												</div>
												</form>
											</div>
										</div>
									</div>
					</div>		
				
				

					<div class='modal fade' id='exampleModal3' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Perfil</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body'>
											<form  action='./model/CtrlModificarU2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModDatosPacienteAdmin();'> 
											<div class='mb-3'>
													<label for='nombre_usm' class='col-form-label'>Nombre(s)</label>
													<input type='text' class='form-control' name='nombre_us' id='nombre_usm' value='".$nombreus."'>
												</div>
												<div class='mb-3'>
													<label for='apellidos_usm' class='col-form-label'>Apellidos(s)</label>
													<input type='text' class='form-control' id='apellidos_usm'  name='apellidos_us' value='".$apellidosus."'>
												</div>
												<div class='mb-3'>
													<label for='telefono_usm' class='col-form-label'>Telefono</label>
													<input type='text' class='form-control' id='telefono_usm' name='telefono_us' value='".$telefonous."'>
												</div>
												<div class='mb-3'>
													<label for='genero_usm' class='col-form-label'>Genero</label>
													<input type='text' class='form-control' id='genero_usm' name='genero_us' value='".$reg['genero_us']."'>
												</div>
												<input type='hidden' name='clave_us' value='".$clave_usuario."'>
												
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												
											</div>
											</form>
										</div>
									</div>
					</div>
					<div class='modal fade' id='exampleModal4' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog '>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Fotoo</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body d-flex align-items-center justify-content-center'>
											<form  action='./model/modificarFoto2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModFotoPacienteAdmin();' class='d-flex align-items-center flex-column'> 
											<img class='img-form' src='".$fotous."' width='100' height='100'>
													<div class='mb-3'>
														<label for='fotous' class='col-form-label'>Selecciona la Imagen</label>
														
														<input type='file' id='fotous' name='foto_us' >
														<input type='hidden' name='correo_uss' value='".$correo."'>

													</div>

													
													
													<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
													</div>
												</form>
											</div>
										</div>
									</div>
					</div>
					<div class='modal fade' id='exampleModal5' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Contraseña</h1>
												<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
											</div>
											<div class='modal-body'>
											<form  action='./model/Ctrlmodificarcontra2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModContraPacienteAdmin();'> 
													<div class='mb-3'>
														<label for='contrasenaus' class='col-form-label'>Contraseña Nueva</label>
														<input type='password' id='contrasenaus' class='form-control' name='contrasena_us' >
													</div>
													<div class='mb-3'>
														<label for='contrarepetida' class='col-form-label'>Repite la Contraseña</label>
														<input type='password' id='contrarepetida' class='form-control'>
													</div>	
													<input type='hidden' name='correo_uss' value='".$correo."'>
										
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												</form>
											</div>
										</div>
									</div>
					</div>
			</ul>
		</div>";
		}
	}
	public function modificarPerfilDoc($iddoc,$nomdoc,$apedoc,$telefonodoc,$cedula,$institucion,$genero){
		mysqli_query($this->obtenerConexion(),"UPDATE doctor 
		SET 
		nombre_doc = '$nomdoc', 
		apellidos_doc = '$apedoc',
		cedula_doc = '$cedula',
		genero_doc = '$genero',
		institucion = '$institucion' , 
		telefono_doc = '$telefonodoc' WHERE iddoctor ='$iddoc' " );
		if($_SESSION['tipoUs'] == 2){
			echo '<script type="text/javascript">
			alert("Perfil de  '.$nomdoc.' Modificado");
			window.location.href="../index.php?pagina=perfilDoctor";
			</script>';
		}else if($_SESSION['tipoUs'] == 3){
			echo '<script type="text/javascript">
			alert("Perfil de  '.$nomdoc.' Modificado");
			window.location.href="../index.php?pagina=registroDoctor";
			</script>';
		}
	}
	public function OpcionMedicina(){
		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM medicina");

			while ($reg=mysqli_fetch_array($registro)){	
				echo "<option value='$reg[0]'>$reg[1]</option>";
			}
		
	}
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*----------------Administrador------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	/*-----------------------------------------------*/
	public function PanelAdminUsuarios(){
		$correo = $_SESSION['usuario'];
		$tipoUs = $_SESSION['tipoUs'];
		
		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM usuarios WHERE correo_us='$correo' AND tipoUsuario='$tipoUs'");		
		while($reg=$registro->fetch_assoc()){
			echo "<div class='d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary' style='width: 280px;'>
			<a style ='cursor:pointer;' data-bs-toggle='modal' data-bs-target='#exampleModalPerfilAdmin".$reg['clave_us'] ."' class='nav-link d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none'>
			  <span class='fs-4'>Administrador ".$reg['nombre_us'] . $reg['apellidos_us']."</span>
			</a>
			<div class='modal fade' id='exampleModalPerfilAdmin".$reg['clave_us'] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog modal-xl'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Perfil Doctor</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
													<div class='modal-body p-5 pt-0'>
														<div class='card text-center'>
															<div ass='card-header'>
															<img src='".$reg['foto_us']."' class='' style='object-fit:contain;object-position:center;border-radius:500px;width:200px;height:200px;' alt='...'>

																<h5>Admin. ".$reg['nombre_us']." ".$reg['apellidos_us']."</h5>
															</div>
															<div class='card-body'>
															<p class='card-text'>Genero : ".$reg['genero_us']."</p>
															<p class='card-text'>Telefono: ".$reg['telefono_us']."</p>
															<p class='card-text'>Correo : ".$reg['correo_us']."</p>

															</div>
															<div class='card-footer text-body-secondary'>
															
															</div>
														</div>
														<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
														</div>        
												  
											  		</div>
												</div>
											</div>
										</div>
										
			</div>
			<hr>
			<ul class='nav nav-pills flex-column mb-auto'>
				<li>
				<a class='nav-link link-body-emphasis' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>Editar Perfil</a>
				<ul class='dropdown-menu'>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalDatosAdmin'>Editar Datos</a></li>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalContraAdmin'>Editar Contraseña</a></li>
					<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalFotoAdmin'>Editar Foto</a></li>
				</ul>
				</li>
				<div class='modal fade' id='exampleModalDatosAdmin' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Perfil</h1>
											<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
										</div>
										<div class='modal-body'>
										<form  action='./model/CtrlModificarU2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModDatosAdmin();'> 
										<div class='mb-3'>
												<label for='nombre_us' class='col-form-label'>Nombre(s)</label>
												<input type='text' class='form-control' name='nombre_us' id='nombre_us' value='".$reg["nombre_us"]."'>
											</div>
											<div class='mb-3'>
												<label for='apellidos_us' class='col-form-label'>Apellidos(s)</label>
												<input type='text' class='form-control' id='apellidos_us'  name='apellidos_us' value='".$reg["apellidos_us"]."'>
											</div>
											<div class='mb-3'>
												<label for='telefono_us' class='col-form-label'>Telefono</label>
												<input type='text' class='form-control' id='telefono_us' name='telefono_us' value='".$reg["telefono_us"]."'>
											</div>
											<div class='mb-3'>
												<label for='genero_us' class='col-form-label'>Genero</label>
												<input type='text' class='form-control' id='genero_us' name='genero_us' value='".$reg["genero_us"]."'>
											</div>
											<input type='hidden' name='clave_us' value='".$reg["clave_us"]."'>
											<input type='hidden' name='opc' value='1'>
											<div class='modal-footer'>
												<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
												<button type='submit' class='btn btn-primary'>Modificar</button>
											</div>
											
										</div>
										</form>
									</div>
								</div>
				</div>
				<div class='modal fade' id='exampleModalFotoAdmin' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								<div class='modal-dialog '>
									<div class='modal-content'>
										<div class='modal-header'>
											<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Foto</h1>
											<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
										</div>
										<div class='modal-body d-flex align-items-center justify-content-center'>
										<form  action='./model/modificarFoto2.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModFotoPaciente();' class='d-flex align-items-center flex-column'> 
										<img class='img-form' src='".$reg["foto_us"]."' width='100' height='100'>
												<div class='mb-3'>
													<label for='foto_us' class='col-form-label'>Selecciona la Imagen</label>
													
													<input require type='file' id='foto_us' name='foto_us' value='".$reg["foto_us"]."'>
													<input type='hidden' name='correo_uss' value='".$reg['correo_us']."'>
												</div>

												
												
												<div class='modal-footer'>
												<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
												<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
											</form>
										</div>
									</div>
								</div>
				</div>
				<div class='modal fade' id='exampleModalContraAdmin' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<h1 class='modal-title fs-5' id='exampleModalLabel'>Editar Contraseña</h1>
											<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
										</div>
										<div class='modal-body'>
										<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModContraAdmin();'> 
													<div class='mb-3'>
														<label for='contra_actual' class='col-form-label'>Contraseña Actual</label>
														<input type='password' id='contra_actual' name='contra_actualus' class='form-control' autocomplete='current-password'>
													</div>
													<div class='mb-3'>
														<label for='contrasena_us' class='col-form-label'>Contraseña Nueva</label>
														<input type='password' id='contrasena_us' class='form-control' name='contrasena_us' autocomplete='current-password'>
													</div>
													<div class='mb-3'>
														<label for='contrasena_repetida' class='col-form-label'>Repite la Contraseña</label>
														<input type='password' id='contra_repetida' name='contrasena_repetida' class='form-control' autocomplete='current-password'>
													</div>	
													<input type='hidden' name='claveus' value='".$reg['clave_us']."'>
													<input type='hidden' name='opc' value='25'>

										
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary'>Modificar</button>
												</div>
												</form>
										</div>
									</div>
								</div>
				</div>

			  <li>
				<a href='#' class='nav-link link-body-emphasis' data-bs-toggle='modal' data-bs-target='#exampleModalRegistrarPaciente'>
				  Registrar Paciente
				</a>
				<div class='modal fade' id='exampleModalRegistrarPaciente' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
										<div class='modal-dialog '>
											<div class='modal-content'>
												<div class='modal-header'>
													<h1 class='modal-title fs-5' id='exampleModalLabel'>Registrar Paciente</h1>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body d-flex align-item-center justify-content-center'>
												
										
												<div class='modal-body p-5 pt-0'>
												<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionRegistroPacienteAdmin();'>
												<div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='nombre_usadmin' name='nombre_us'>
													<label for='nombre_usadmin'>Nombre(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='apellidos_usadmin' name='apellidos_us' >
													<label for='apellidos_usadmin'>Apellidos(s)</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='telefono_usadmin' name='telefono_us'>
													<label for='telefono_usadmin'>Telefono</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='file'  class='form-control rounded-3' id='foto_usadmin' name='foto_us' >
													<label for='foto_usadmin'>Foto</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='text' class='form-control rounded-3' id='correo_usadmin' name='correo_us' >
													<label for='correo_usadmin'>Correo</label>
												  </div>
												  <div class='form-floating mb-3'>
													<input type='password' class='form-control rounded-3' id='contrasena_usadmin' name='contrasena_us' >
													<label for='contrasena_usadmin'>Contraseña</label>
												  </div>
												
												  <input type='hidden' name='opc' value='1'>
												  <div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
													<button type='submit' class='btn btn-primary'>Registrar</button>
												  </div>        
												</form>    
											  </div>

														
						
													
												</div>
											</div>
										</div>
										
				</div>
			
			  </li>
			  <li>
				<a href='./index.php?pagina=registroDoctor' class='nav-link link-body-emphasis' >
				Doctores
				</a>
				
			  </li>


			  <li>
				<a href='./index.php?pagina=medicamentoRegistrado' class='nav-link link-body-emphasis'>
				  Medicamentos Registrados
				</a>
			  </li>

			  <li>
				<a href='./index.php?pagina=formasMedicas' class='d-flex nav-link link-body-emphasis'>
				  Formas Medicas Registradas
				</a>
			  </li>

			  <li>
				<a href='./index.php?pagina=viasConsumo' class='d-flex nav-link link-body-emphasis'>
				  Vias de Consumo Registradas
				</a>
			  </li>
			</ul>
			
		  </div>";
		}
	}
	public function agregarDoc($nomdoc,$apedoc,$telefonodoc,$cedula,$institucion,$genero,$correo_doc,$contra_doc,$foto_doc){
		$registro=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor where correo_doc='$correo_doc'");
		if($reg=mysqli_fetch_array($registro)){
			echo'<script type="text/javascript">
        alert("El correo del Doctor ya se encuentra Registrado");
        window.location.href="../index.php?pagina=perfilAdmin";

        </script>';
		}else{
		$contra_doctor = hash('sha512',$contra_doc);
		$conn=$this->obtenerConexion();

		
		$ingresarDoctor = "INSERT INTO doctor(nombre_doc,apellidos_doc,cedula_doc,genero_doc,institucion,telefono_doc,foto_doc,correo_doc,contrasena_doc,tipoUsuario) VALUES 
		('$nomdoc','$apedoc','$cedula','$genero','$institucion','$telefonodoc','$foto_doc','$correo_doc','$contra_doctor',2)";
		$conn->query($ingresarDoctor);
		$idDoctorIngresado = $conn->insert_id;
		echo'<script type="text/javascript">
        alert("Registro de Doctor Realizado ");
        window.location.href="../index.php?pagina=registroDoctor";
        </script>';
		//header("location: ../vistas/IniciarSesion.php");
		}
	}
	public function VerDoctor(){
		$registros=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor");
		while($reg=mysqli_fetch_array($registros)){
			$iddoctor = $reg['iddoctor'];
			
			echo "

				<div class='col-sm-6 mb-2 mt-2 '>
					<div class='card'>
						<div class='card-body'>
							<div class='row'>
								<div class='col-sm-6 mb-2 mt-2'>
									<h5 class='card-title' id='doctor'>ID :".$iddoctor."</h5>	
									<h6 class='card-title'>Nombre(s) : ".$reg['nombre_doc']."</h6>
									<h6 class='card-title'>Apellidos : ".$reg['apellidos_doc']."</h6>	
									<h6 class='card-title'>Cedula : ".$reg['cedula_doc']."</h6>	
									<h6 class='card-title'>Genero : ".$reg['genero_doc']."</h6>	
									<h6 class='card-title'>Institucion : ".$reg['institucion']."</h6>	
									<h6 class='card-title'>Telefono : ".$reg['telefono_doc']."</h6>	
									<h6 class='card-title'>Correo : ".$reg['correo_doc']."</h6>	
								</div>
								<div class='col-sm-6 mb-2 mt-2 d-flex align-items-center justify-content-center'>
									<img src='".$reg['foto_doc']."' class='img-fluid' style='max-width: 70%;
									max-height: 70%;' alt='...'>
								</div>
							</div>
							<hr>

							<div class='container d-flex justify-content-evenly align-items-center'>

							<li class=' btn' >
								<a class='dropdown-toggle btn btn-outline-primary' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>Editar Perfil</a>
								<ul class='dropdown-menu'>
									<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarDatosDoc".$iddoctor."'>Editar Datos</a></li>
									<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarContraDoc".$iddoctor."'>Editar Contraseña</a></li>
									<li class='nav-item' style='cursor:pointer;'><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#exampleModalModificarFotoDoc".$iddoctor."'>Editar Foto</a></li>
								</ul>
							</li>
							
								<div class='modal fade' id='exampleModalModificarDatosDoc".$iddoctor."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
											<div class='modal-dialog '>
												<div class='modal-content'>
													<div class='modal-header'>
														<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Doctor</h1>
														<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
													</div>
													<div class='modal-body d-flex align-item-center justify-content-center'>
													
											
														<form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModDatosDoctorAdmin(".$iddoctor.");'> 

															<div class='mb-3'>
															<label class='col-form-label' for='nombre_docmad".$iddoctor."'>Nombre Doctor</label>
															<input type='text' class='form-control' id='nombre_docmad".$iddoctor."' name='nombre_doc' value='".$reg['nombre_doc']."'>
															</div>
															<div class='mb-3'>
																<label class='col-form-label' for='apellidos_docmad".$iddoctor."'>Apellidos Doctor</label>
																<input type='text' class='form-control' id='apellidos_docmad".$iddoctor."' name='apellidos_doc' value='".$reg['apellidos_doc']."'>
															</div>
															<div class='mb-3'>
																<label class='col-form-label' for='cedula_docmad".$iddoctor."'>Cedula Doctor</label>
																<input type='text' class='form-control' id='cedula_docmad".$iddoctor."' name='cedula_doc' value='".$reg['cedula_doc']."'>
															</div>
															<div class='mb-3'>
																<label class='col-form-label' for='genero_docmad".$iddoctor."'>Genero</label>
																<input type='text' class='form-control' id='genero_docmad".$iddoctor."' name='genero_doc' value='".$reg['genero_doc']."'>
															</div>
															<div class='mb-3'>
																<label class='col-form-label' for='institucionmad".$iddoctor."'>Institucion</label>
																<input type='text' class='form-control' id='institucionmad".$iddoctor."' name='institucion' value='".$reg['institucion']."'>
															</div>
															<div class='mb-3'>
																<label class='col-form-label' for='telefono_docmad".$iddoctor."'>Telefono</label>
																<input type='text' class='form-control' id='telefono_docmad".$iddoctor."'  name='telefono_doc' value='".$reg['telefono_doc']."'>
															</div>
															
															
															
															<input type='hidden' name='iddoc' value='".$iddoctor."'>
															<input type='hidden' name='opc' value='19'>

															<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
															<button type='submit' class='btn btn-primary'>Modificar</button>
															
															</div>
														</form>
														
													</div>
												</div>
											</div>
											
								</div>
								<div class='modal fade' id='exampleModalModificarFotoDoc".$iddoctor."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
											<div class='modal-dialog '>
												<div class='modal-content'>
													<div class='modal-header'>
														<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Doctor</h1>
														<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
													</div>
													<div class='modal-body d-flex align-item-center justify-content-center'>
													<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModFotoDoctorAdmin(".$iddoctor.");' class='d-flex align-items-center flex-column'> 
													<img class='img-form' src='".$reg["foto_doc"]."' width='100' height='100'>
															<div class='mb-3'>
																<label for='foto_docmad".$iddoctor."' class='col-form-label'>Selecciona la Imagen</label>
																
																<input require type='file' id='foto_docmad".$iddoctor."' name='foto_doc' value='".$reg["foto_doc"]."'>
																<input type='hidden' name='iddoctor' value='".$iddoctor."'>
																<input type='hidden' name='opc' value='21'>
		
															</div>
		
															
															
															<div class='modal-footer'>
															<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
															<button type='submit' class='btn btn-primary'>Modificar</button>
															</div>
														</form>
													</div>
												</div>
											</div>
											
								</div>
								<div class='modal fade' id='exampleModalModificarContraDoc".$iddoctor."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
											<div class='modal-dialog '>
												<div class='modal-content'>
													<div class='modal-header'>
														<h1 class='modal-title fs-5' id='exampleModalLabel'>Modificar Doctor</h1>
														<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
													</div>
													<div class='modal-body d-flex align-item-center justify-content-center'>
													
											
													<form  action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionModContraDoctorAdmin(".$iddoctor.");'> 
													
													<div class='mb-3'>
														<label for='contra_nueva".$iddoctor."' class='col-form-label'>Contraseña Nueva</label>
														<input type='password' id='contra_nueva".$iddoctor."' class='form-control' name='contrasena_doc'>
													</div>
													<div class='mb-3'>
														<label for='contra_repetida".$iddoctor."' class='col-form-label'>Repite la Contraseña</label>
														<input type='password' id='contra_repetida".$iddoctor."' class='form-control' >
													</div>	
													<input type='hidden' name='iddoctor' value='".$iddoctor."'>
													
													<input type='hidden' name='opc' value='22'><div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
													<button type='submit' class='btn btn-primary' >Modificar</button>

												</div>
												</form>
														
													</div>
												</div>
											</div>
											
								</div>
							
									
								
							</div>

										
								
						</div>
					</div>
				</div>";
				/*<form action='./controller/CtrlUsuario.php' method='post' class='mb-0'>
								<input type='hidden' name='opc' value='15'>
								<input type='hidden' name='idvia' value='".$iddoctor."'>
								<button class='btn btn-outline-danger' type='submit'>Eliminar</button>
								</form>*/
								

		}
		
	}
	public function modificarFotoDoc($foto_doc,$clave_doc){
		
		$registro=mysqli_query($this->obtenerConexion(),"UPDATE doctor set foto_doc='$foto_doc'
		where iddoctor='$clave_doc'");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3){
			echo'<script type="text/javascript">
			alert("Foto Modificada");
			window.location.href="../index.php?pagina=registroDoctor";
			</script>';		}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2){
				echo'<script type="text/javascript">
				alert("Foto Modificada");
				window.location.href="../index.php?pagina=perfilDoctor";
				</script>';		}
	}
	public function modificarContraDoc($contrasena_doc,$clave_doc,$contrasena_actual) {
		$contrasena_doc = hash('sha512',$contrasena_doc);
		
		$contrasena_actual = hash('sha512',$contrasena_actual);
		$consulta=mysqli_query($this->obtenerConexion(),"SELECT * FROM doctor WHERE iddoctor='$clave_doc'");
		$respuesta=$consulta->fetch_assoc();
		
		if($_SESSION['tipoUs'] == 2){

			if($contrasena_actual== $respuesta['contrasena_doc']){
				$registro=mysqli_query($this->obtenerConexion(),"UPDATE doctor set contrasena_doc='$contrasena_doc' where iddoctor='$clave_doc'");
				if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2){
					header("location: ../index.php?pagina=perfilDoctor");
				}
			}else{
				if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2){
					echo'<script type="text/javascript">
				alert("La contraseña actual no coincide con la registrada");
				window.location.href="../index.php?pagina=perfilDoctor";
				</script>';
				}
			}
		}else if($_SESSION['tipoUs'] == 3){
			$registro=mysqli_query($this->obtenerConexion(),"UPDATE doctor set contrasena_doc='$contrasena_doc' where iddoctor='$clave_doc'");
			echo'<script type="text/javascript">
				alert("Contraseña Modificada");
				window.location.href="../index.php?pagina=registroDoctor";
				</script>';

		}
	}
}
/*Patrond de diseño Comand*/
class ComandoEliminarCita {
    private $idCita;
    public function __construct($idCita) {
    $this->idCita = $idCita;
    }
	/*Command (ejecutar):
	ejecutar contiene la lógica específica del comando. En este caso, se ejecuta una consulta SQL para eliminar un usuario en la base de datos.*/
    public function ejecutar($conexion) {
		mysqli_query($conexion,"DELETE N FROM notificacionCitas N WHERE N.claveCita = '$this->idCita'");
		mysqli_query($conexion,"DELETE FROM cita WHERE clave_cita = '$this->idCita'");
		if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==2 ){
			header("location: ../index.php?pagina=perfilDoctor");
			}else if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 ){
				header("location: ../index.php?pagina=perfilAdmin");
			}	
    }
}
?>