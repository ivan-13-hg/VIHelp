<?php
if (isset($_SESSION['usuario']) && isset($_SESSION['tipoUs']) == 3) {
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
    <li class="breadcrumb-item">
        <a class="link-body-emphasis fw-semibold text-decoration-none" href="./index.php?pagina=inicio">Inicio</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Perfil
      </li>
    </ol>
</nav>
<div class="container-fluid mb-4 mt-4">
    <div class="row">
        <div class="col-md-auto d-flex justify-content-center">   
        <?php
        $u->PanelAdminUsuarios();  
        ?>
        </div>
        <div class="col">
            <div class="container-fluid d-flex flex-column align-items-center">
            <h2>Buscador de Pacientes</h2>
                <input class='form-control me-2 mb-3' type='text' onkeyup="buscar_paciente($('#buscadorpaciente').val());"  id='buscadorpaciente' name='buscadorpaciente' placeholder='Ingresa el ID o Nombre del paciente' aria-label='Search'>
                <button class='btn btn-outline-success' onclick="buscar_paciente($('#buscadorpaciente').val());" >Buscar</button>
            </div>

            <div class="container" id='paciente_buscado'>
            </div>

        </div> 
    </div>
</div>
<script type='text/javascript'>
    function buscar_paciente(buscadorpaciente){
        var parametros = {'buscadorpaciente':buscadorpaciente};
        $.ajax({
            data:parametros,
            type: 'POST',
            url:'./controller/buscarPaciente.php',
            success: function(data){
                $('#paciente_buscado').html(data);
            }
        });
    }    
</script>
<hr>
<?php
}else{
  echo'<script type="text/javascript">
        alert("Inicia Sesion");
        window.location.href="./index.php?pagina=IniciarSesion";
        </script>';
exit; 
}
?>
