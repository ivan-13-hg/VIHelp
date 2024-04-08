    <?php
    session_start();
    include_once 'Usuario.php';
    // Obtener la instancia de Usuario
    /*Singleton (en $usuario = Usuario::obtenerInstancia();):
Se obtiene la instancia única de la clase Usuario.*/ 
    $u = Usuario::obtenerInstancia();
    // Obtener la conexión a la base de datos
			switch($_REQUEST['opc']){
        //REGISTRO DE PACIENTE
				case 1:
          $nombre_us=$_REQUEST['nombre_us'];
          $apellidos_us=$_REQUEST['apellidos_us'];
          $telefono_us=$_REQUEST['telefono_us'];
          $correo_us=$_REQUEST['correo_us'];
          $contrasena_us=$_REQUEST['contrasena_us'];

          $nombre_imagen=$_FILES['foto_us']['name'];
          $temporal=$_FILES['foto_us']['tmp_name'];
          $carpeta='../view/assets/img';
          $carpetamuestra='./view/assets/img';
          $foto_us=$carpetamuestra.'/'.$nombre_imagen;
          move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);
          

					$u->inicializar($nombre_us,$apellidos_us,$telefono_us,$correo_us,$contrasena_us,$foto_us);
					$u->ingresarUsuario($contrasena_us);
				break;
        //ELIMINAR USUARIO(NO SE UTILIZA)
				case 2:
          if (isset($_SESSION['usuario'])) {
					$u->borrarUsuario($_REQUEST['clave_us']);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');}
				break;
        
				case 3:
				break;
        //MODIFICAR USUARIO
				case 4:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 1 || isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
					$u->modificarUsuario($_REQUEST['correo_us']);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');}
				break;
/*--------------------------------------------------------INICIO DE SESION------------------------------------------------------*/            
        case 5:
					$u->entrar($_REQUEST['correo_us'],$_REQUEST['contrasena_us']);
				break;		
/*--------------------------------------------------------TRATAMIENTO------------------------------------------------------*/            

        //AGREGAR MEDICAMENTO
        case 6:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
          $nombre_med=$_REQUEST['nombre_med'];
          $forma_med=$_REQUEST['forma_med'];
          $dosis_med=$_REQUEST['dosis_med'];
          $fre_med=$_REQUEST['fre_med'];
          $via_med=$_REQUEST['via_med'];
          $duracion_med=$_REQUEST['duracion_med'];
          $indicacion_med=$_REQUEST['indicacion_med'];
          $fecha_med=$_REQUEST['fecha_med'];
          $clave_us=$_REQUEST['clave_us'];
          $clave_doc=$_REQUEST['clave_doc'];
          echo $nombre_med;

          $u->AgregarMedicamento($nombre_med,$forma_med,$dosis_med,$fre_med,$via_med,$duracion_med,$indicacion_med,$fecha_med,$clave_us,$clave_doc);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //BORRAR MEDICAMENTO  
        case 7:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
          $clave_med=$_REQUEST['clave_med'];
          $correo_paciente=$_REQUEST['correo_us'];
          $u->borrarMedicamento($clave_med,$correo_paciente);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //AGREGAR CITA 
        case 8:
          if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 2 || $_SESSION['tipoUs'] == 3) {
          $fecha_cita=$_REQUEST['fecha_cita'];
          $lugar_cita=$_REQUEST['lugar_cita'];
          $indi_cita=$_REQUEST['indi_cita'];
          $clave_us=$_REQUEST['clave_us'];
          $clave_doc = $_REQUEST['id_doctor'];
          echo $clave_doc;
          $u->AgregarCita($fecha_cita,$lugar_cita,$indi_cita,$clave_us,$clave_doc);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');}
        break;
        //ELIMINAR CITA PATRON DE DISEÑO COMMAND
        case 9:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
          /*
          Command (en $comandoEliminarUsuario = $usuario->comandoEliminarUsuario($idUsuarioAEliminar); y $usuario->ejecutarComando($comandoEliminarUsuario);):
          Se crea un comando específico para eliminar un usuario (ComandoEliminarUsuario) y se ejecuta mediante el método ejecutarComando en la instancia de Usuario. Esto proporciona una separación clara entre el cliente y la lógica específica de la operación a realizar.*/ 
          //$clave_cita=$_REQUEST['clave_cita'];
          $idCitaAEliminar=$_REQUEST['clave_cita'];
          $comandoEliminarCita = $u->comandoEliminarCita($idCitaAEliminar);
          $u->ejecutarComando($comandoEliminarCita); 
          //$u->borrarCita($clave_cita);
          }  else {
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
/*--------------------------------------------------------MEDICINA------------------------------------------------------*/            
        //AGREGAR
        case 10:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
              $nombreMed = $_REQUEST['nombre_medicina'];
              $descripcion = $_REQUEST['des_medicina'];
              $u->AgregarMedicina($nombreMed,$descripcion);
          }else{
            header('Location: ../index.php?pagina=IniciarSesion');

          }
        break;
        //MODIFICAR
        case 11:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $nombreMed = $_REQUEST['nombre_med'];
            $descripcion = $_REQUEST['descripcion_med'];
            $idmed = $_REQUEST['clave_med'];
            $u->ModificarMedicina($nombreMed,$descripcion,$idmed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //ELIMINAR
        case 12:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $idmed = $_REQUEST['clave_med'];
            $u->eliminarMedicina($idmed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
/*--------------------------------------------------------VIAS DE ADMINISTRACION------------------------------------------------------*/   
        //AGREGAR  
        case 13:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $viamed = $_REQUEST['viamed'];
            $u->AgregarVias($viamed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //MODIFICAR
        case 14:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $idvia= $_REQUEST['idvia'];
            $viamed = $_REQUEST['viamed'];
            $u->ModificarVias($viamed,$idvia);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //ELIMINAR
        case 15:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $idvia = $_REQUEST['idvia'];
            $u->eliminarVias($idvia);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
/*--------------------------------------------------------FORMA MEDICA------------------------------------------------------*/            
        //AGREGAR  
        case 16: 
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $formaMed = $_REQUEST['formamed'];
            $u->AgregarFormaMed($formaMed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //MODIFICAR
        case 17:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $formaMed = $_REQUEST['formamed'];
            $idforma = $_REQUEST['idforma'];
            $u->ModificarForma($idforma,$formaMed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //ELIMINAR
        case 18:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $idforma = $_REQUEST['idforma'];
            $u->eliminarForma($idforma);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
/*--------------------------------------------------------MODIFICAR PERFIL DOC------------------------------------------------------*/            
        //MODIFICAR DOC
        case 19:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2 || isset($_SESSION['tipoUs']) == 3) {
            $iddoc = $_REQUEST['iddoc'];
            $nomdoc = $_REQUEST['nombre_doc'];
            $apedoc = $_REQUEST['apellidos_doc'];
            $telefonodoc = $_REQUEST['telefono_doc'];
            $cedula = $_REQUEST['cedula_doc'];
            $institucion = $_REQUEST['institucion'];
            $genero = $_REQUEST['genero_doc'];

            $u->modificarPerfilDoc($iddoc,$nomdoc,$apedoc,$telefonodoc,$cedula,$institucion,$genero);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break; 
        //INGRESAR DOC
        case 20:
          if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3) {
            $nomdoc = $_REQUEST['nombre_doc'];
            $apedoc = $_REQUEST['apellidos_doc'];
            $telefonodoc = $_REQUEST['telefono_doc'];
            $cedula = $_REQUEST['cedula_doc'];
            $institucion = $_REQUEST['institucion'];
            $genero = $_REQUEST['genero_doc'];
            $correo_doc = $_REQUEST['correo_doc'];
            $contra_doc = $_REQUEST['contra_doc'];
            $nombre_imagen=$_FILES['foto_doc']['name'];
            $temporal=$_FILES['foto_doc']['tmp_name'];
            $carpeta='../view/assets/img';
            $carpetamuestra='./view/assets/img';
            $foto_doc=$carpetamuestra.'/'.$nombre_imagen;
            move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);

            $u->agregarDoc($nomdoc,$apedoc,$telefonodoc,$cedula,$institucion,$genero,$correo_doc,$contra_doc,$foto_doc);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break; 
        //MODIFICAR FOTO DOC
        case 21:
          if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3 || $_SESSION['tipoUs'] == 2) {
            $clave_doc=$_REQUEST['iddoctor'];
            $nombre_imagen=$_FILES['foto_doc']['name'];
            $temporal=$_FILES['foto_doc']['tmp_name'];
            $carpeta='../view/assets/img';
            $carpetamuestra='./view/assets/img';
            $foto_doc=$carpetamuestra.'/'.$nombre_imagen;
            move_uploaded_file($temporal,$carpeta.'/'.$nombre_imagen);            
            $u->modificarFotoDoc($foto_doc,$clave_doc);
            
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }


          
        break;
        //MODIFICAR CONTRA DOC
        case 22:
          if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] ==  3 || $_SESSION['tipoUs'] ==  2) {
            $clave_doc=$_REQUEST['iddoctor'];
            $contrasena_doc=$_REQUEST['contrasena_doc'];
            $contrasena_actual='';
            if($_SESSION['tipoUs'] == 2){
            $contrasena_actual = $_REQUEST['contra_actual'];
            }
            $u->modificarContraDoc($contrasena_doc,$clave_doc,$contrasena_actual);
            
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //AGREGAR NUMERO DE CITA TRATAMIENTO
        case 23:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2) {
            $clavemed = $_REQUEST['clave_med'];
            $numcita = $_REQUEST['numerocita'];
            
            $u->agregarcitaTratamiento($numcita,$clavemed);
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
        //ELIMINAR CITA TRATAMIENTO
        case 24:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 2) {
            $clavecitamed = $_REQUEST['clavecitamed'];
            $u->eliminarcitaMed($clavecitamed);
          }else{
          header('Location: ../index.php?pagina=perfilDoctor');
          }
        break;
        //MODIFICAR CONTRA ADMIN
        case 25:
          if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 3) {
            $clave_us=$_REQUEST['claveus'];
            $contrasena_us=$_REQUEST['contrasena_us'];
            $contrasena_actual=$_REQUEST['contra_actualus'];

            
            $u->modificarContraAdmin($contrasena_us,$clave_us,$contrasena_actual);
            $u->desconectar();
          }else{
          header('Location: ../index.php?pagina=IniciarSesion');
          }
        break;
			}
			$u->desconectar();
			?>
       




