<!DOCTYPE html>
<html lang="es" >
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>VIHelp</title>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.6/push.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!--PWA-->
      <link rel="manifest" href="./manifest.json"> 
     <!---PWA--->
     <!----METAS DE PWA-->
     <style>
@import url('https://fonts.googleapis.com/css2?family=Aboreto&family=Hedvig+Letters+Sans&family=Madimi+One&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Ysabeau+Office:ital,wght@0,1..1000;1,1..1000&display=swap');
    </style>
    <meta name="theme-color" content="#2F3BA2">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" type="image/png" href="./view/assets/img/icon/v-512.png">
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-512.png">
    <link rel="apple-touch-startup-image" href="./view/assets/img/icon/v-512.png">
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-72.png" />
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-96.png" />
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-128.png"/>
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-144.png"/>
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-152.png"/>
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-192.png"/>
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-384.png"/>
    <link rel="apple-touch-icon" href="./view/assets/img/icon/v-512.png"/>
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />


  </head>
  <body style=' font-family: "Plus Jakarta Sans", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
  ' >
  <?php 
         include ('./controller/Usuario.php');
         $u= Usuario::obtenerInstancia();
       
?>
  <?php include ('model/header.php'); ?>    
  <main>
    <?php
        if(isset($_GET["pagina"])){
            if($_GET["pagina"] == "inicio"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "nosotros"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "servicios"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "IniciarSesion"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "perfil"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "perfilDoctor"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "perfilAdmin"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "Ctrlmodificarcontra2"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "CtrlModificarU2"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "modificarCita2"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "modificarFoto2"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "modificarMed2"){
                include "./model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "formasMedicas"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "medicamentoRegistrado"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "viasConsumo"){
                include "model/".$_GET["pagina"].".php";
            }
            if($_GET["pagina"] == "registroDoctor"){
                include "model/".$_GET["pagina"].".php";
            }
        }
        else{
            include ('./view/model/inicio.php');

            
        }
    ?>
    </main>
    <?php include ('model/footer.php'); 
        if(isset($_SESSION['usuario']) && $_SESSION['tipoUs'] == 1){
    ?>
        <script src="./view/assets/js/notificacionMedicamento.js"></script>
        <script src="./view/assets/js/notificacionCita.js"></script>
    <?php
    }else{
        
    }
 ?>
    <script src="./view/assets/js/validaciones.js" ></script>
    <script src="./regist_serviceWorker.js"></script>
    <script src="./Service_Worker.js"></script>
   

    
  </body>
  
</html>

