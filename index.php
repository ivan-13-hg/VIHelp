<?php 
session_start();
require "controller/ctrPlantilla.php";
$plantilla = new Plantilla();
$plantilla->ctrPlantilla();
?>