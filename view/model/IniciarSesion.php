<div class="container text-center">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-center">
      <img class='img-fluid' src="./view/assets/img/soci/VI.png" alt="">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 ">
      <div class="modal modal-sheet position-static d-block  p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0 justify-content-center">
              <h1 class="fw-bold mb-0 fs-2">Inicia Sesion</h1>

            </div>

            <div class="modal-body p-5 pt-0">
              <form class="" action="./controller/CtrlUsuario.php" method="post" onsubmit='return ValidarIniciodeSesion();'>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control rounded-3" id='correo_us' name="correo_us" placeholder="name@example.com">
                  <label for="floatingInput">Correo</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control rounded-3" id='contra_us' name="contrasena_us" placeholder="Password">
                  <label for="floatingPassword">Contraseña</label>
                </div>
                <input type="hidden" name="opc" value="5">
                <hr class="my-4">

                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Iniciar</button>


              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>