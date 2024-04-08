<section class="d-flex justify-content-around align-items-center p-1 text-white" style="
background-color: rgba(0, 0, 0, 0.2);background-image: radial-gradient(circle at 50% 50%, #2f3f5c 0, #1c2331 50%, #010206 100%); text-decoration: none; ">
      <!-- Left -->
      <div class="me-5">
        <span>
VIHelp  </span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <img class="me-4" style="width: 24px; height: 24px; " src="./view/assets/img/soci/facebook.png" alt="">
        <img class="me-4" style="width: 24px; height: 24px; " src="./view/assets/img/soci/insta.png" alt="">
        <img class="me-4" style="width: 24px; height: 24px; " src="./view/assets/img/soci/whatsapp.png" alt="">
      </div>
      <!-- Right -->
    </section>



  <nav class="navbar navbar-expand-lg " aria-label="Eighth navbar example" style="padding:0%; background-image: radial-gradient(circle at 50% 50%, #ecffff 0, #e2ffff 50%, #d8fbfc 100%);">
    <div class="container" style="width: auto;">
    <a class="" href="#"><img style="width: 128px; height: 128px; " src="./view/assets/img/soci/VIH1.png" alt=""></a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample07" style="">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=inicio">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=nosotros">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?pagina=servicios">Servicios</a>
          </li>
          <?php
          if (isset($_SESSION['usuario']) ) {  
            if ($_SESSION['tipoUs'] == 1 ) {
              echo '<li class="nav-item"><a class="nav-link" href="./index.php?pagina=perfil">Perfil</a></li>';
            }else if ($_SESSION['tipoUs'] == 2 ) {
              echo '<li class="nav-item"><a class="nav-link" href="./index.php?pagina=perfilDoctor">Perfil</a></li>';

            }else if ($_SESSION['tipoUs'] == 3 ) {
              echo '<li class="nav-item"><a class="nav-link" href="./index.php?pagina=perfilAdmin">Perfil</a></li>';

            }

          echo '<li class="nav-item"><a class="nav-link" href="./controller/cerrar.php">Cerrar Sesion</a></li>';
          }else{
          echo '<li class="nav-item"><a class="nav-link" href="index.php?pagina=IniciarSesion">Iniciar Sesion</a></li>';
          }
          ?>
        </ul>
        
      </div>
    </div>
  </nav>

  