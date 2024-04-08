<?php
  if (isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1) {
  $u->listarusuarios();
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
                $u->MostrarMedicamentos();
              ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 ">  
            <div class="card mb-5 shadow-sm" style="border: var(--bs-card-border-width) solid rgb(0 0 0 / 13%)">
              <div class='container marketing'> 
                <h1>Citas registradas</h1>
              </div>
              <?php
              $u->MostrarCita();
              ?>
            </div>
          </div>
        </div>
      </div>
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



