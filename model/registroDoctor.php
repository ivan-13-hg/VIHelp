<?php
if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 3) {
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
    <li class="breadcrumb-item">
        <a class="link-body-emphasis fw-semibold text-decoration-none" href="./index.php?pagina=inicio">Inicio</a>
      </li>
      <li class="breadcrumb-item">
        <a class="link-body-emphasis fw-semibold text-decoration-none" href="./index.php?pagina=perfilAdmin">Perfil</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Registro Doctor
      </li>
    </ol>
</nav>
<div class="container-fluid mb-4 mt-4 ">
    <div class="row">
        <div class="col-md-auto d-flex justify-content-center">   
        <?php
        if($_SESSION['tipoUs'] == 3){
            $u->PanelAdminUsuarios();
        }
        ?>
        </div>
        <div class="col">
            <div class="container-fluid d-flex flex-column align-items-center">
            <h2>Registro de Doctor</h2>
            </div>
            <div class="container" id='paciente_buscado'>
            <div class="container d-flex justify-content-center">
            <?php
            echo "<button type='button' class='btn btn-outline-primary mb-2 mt-2' style='display:flex;width:150px;height:50px;align-items:center;justify-content:center;' 
            data-bs-toggle='modal' data-bs-target='#exampleModalAgregarDoctor' data-bs-whatever='@mdo'>Registrar Doctor</button>
            </div>
            <div class='modal fade' id='exampleModalAgregarDoctor' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog '>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Agregar Doctor</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body d-flex align-item-center justify-content-center'>
                        
                
                            <form action='./controller/CtrlUsuario.php' method='post' enctype='multipart/form-data' onsubmit='return ValidacionRegistroDoctor();'> 
    
                                <div class='mb-3'>
                                    <label class='col-form-label' for='nombre_docag'>Nombre Doctor</label>
                                    <input type='text' class='form-control' id='nombre_docag'  name='nombre_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='apellidos_docag'>Apellidos Doctor</label>
                                    <input type='text' class='form-control' id='apellidos_docag'  name='apellidos_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='cedula_docag'>Cedula Doctor</label>
                                    <input type='text' class='form-control' id='cedula_docag' name='cedula_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='genero_docag'>Genero</label>
                                    <input type='text' class='form-control' id='genero_docag' name='genero_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='institucionag'>Institucion</label>
                                    <input type='text' class='form-control' id='institucionag' name='institucion'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='foto_docag'>Foto</label>
                                    <input type='file' class='form-control' id='foto_docag' name='foto_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='telefono_docag'>Telefono</label>
                                    <input type='text' class='form-control' id='telefono_docag' name='telefono_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='correo_docag'>Correo</label>
                                    <input type='text' class='form-control' id='correo_docag'  name='correo_doc'>
                                </div>
                                <div class='mb-3'>
                                    <label class='col-form-label' for='contra_docag'>Contraseña</label>
                                    <input type='password' class='form-control' id='contra_docag' name='contra_doc'>
                                </div>
                                
        
                                <input type='hidden' name='opc' value='20'>
    
                                <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar Ventana</button>
                                <button type='submit' class='btn btn-primary'>Agregar</button>
                                
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                
            </div>";
            ?>
            <div class="bd-example border-0 mb-2 mt-2">
                <div class="row">
                <?php
                $u->VerDoctor();
                ?>
                </div>
            </div>
            </div>

        </div> 
    </div>
</div>
<?php
}else{
  echo'<script type="text/javascript">
        alert("Inicia Sesion");
        window.location.href="./index.php?pagina=IniciarSesion";
        </script>';
exit; 
}
?>
