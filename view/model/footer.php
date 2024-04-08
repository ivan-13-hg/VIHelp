<!-- Remove the container if you want to extend the Footer to full width. -->
<div class="">

  <!-- Footer -->
  <footer
          class="text-center text-lg-start text-white"
          style="background-image: radial-gradient(circle at 50% 50%, #2f3f5c 0, #1c2331 50%, #010206 100%);"
          >
    <!-- Section: Social media -->
    <section
             class="d-flex justify-content-center align-items-center p-2 text-dark"
             style="background-image: linear-gradient(185deg, #e2ffff 0, #ddf7f6 50%, #d9ebeb 100%); text-decoration: none; "
             >
      <!-- Left -->
      <div class="me-5">
        <span>
Conéctate con nosotros en nuestras redes sociales : </span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <img class="me-4" src="./view/assets/img/soci/facebook.png">
        <img class="me-4" src="./view/assets/img/soci/insta.png" alt="">
        <img class="me-4" src="./view/assets/img/soci/whatsapp.png" alt="">
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 d-flex align-items-center flex-column">
            <!-- Content -->
            <h6 class="fw-bold">VIHelp</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px">
            <p>
            VIHelp se propone como la respuesta a estas preocupaciones, ofreciendo una 
plataforma única que guie al usuario para tener un control adecuado de sus tratamientos 
basándose primordialmente en notificaciones con alertas, esto para apegarse fielmente 
a su tratamiento previamente establecido por su médico de confianza.
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4 d-flex align-items-center flex-column">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Navega</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px">
            <p class="">
            <a class="nav-link" href="index.php?pagina=inicio">Inicio</a>
</p>
          <p >
            <a class="nav-link" href="index.php?pagina=nosotros">Nosotros</a>
</p>
          <p >
            <a class="nav-link" href="index.php?pagina=servicios">Servicios</a>
</p>
          <?php
          if (isset($_SESSION['usuario']) ) {  
            if ($_SESSION['tipoUs'] == 1 ) {
              echo '<p ><a class="nav-link" href="./index.php?pagina=perfil">Perfil</a></p>';
            }else if ($_SESSION['tipoUs'] == 2 ) {
              echo '<p ><a class="nav-link" href="./index.php?pagina=perfilDoctor">Perfil</a></p>';
            }else if ($_SESSION['tipoUs'] == 3 ) {
              echo '<p ><a class="nav-link" href="./index.php?pagina=perfilAdmin">Perfil</a></p>';
            }
            echo '<p ><a class="nav-link" href="./controller/cerrar.php">Cerrar Sesion</a></p>';
          }else{
            echo '<p "><a class="nav-link" href="index.php?pagina=IniciarSesion">Iniciar Sesion</a></p>';
          }
          ?>
          
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4 d-flex align-items-center flex-column">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Contactanos</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px">
            
            <p><i class="fas fa-envelope mr-3"></i> TeamScrum@gmail.com</p>
            <p><i class="fas fa-phone mr-3"></i> +56 55 89 89 56 45</p>
            <p><i class="fas fa-print mr-3"></i> +56 30 56 80 56 45</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
      © 2024 Copyright:
      <a class="text-white " href=""
         >TeamScrum</a
        >
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->

</div>
<!-- End of .container -->