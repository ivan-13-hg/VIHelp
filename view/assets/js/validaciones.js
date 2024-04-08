//VALIDAR INICIO DE SESION 
function ValidarIniciodeSesion(){
    var correo = document.getElementById("correo_us").value;
    var contra = document.getElementById("contra_us").value;
    var validacion_correo = /\w+@\w+\.+[a-z]/;
    if(correo === "" || contra === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(correo.length>100){
        alert("El correo es muy largo");
        return false;
    }
    else if(!validacion_correo.test(correo)){
        alert("El correo no tiene un formato valido");
        return false;
    }
}
/*---------------------------------------------------
-----------------------------------------------------
---------------------DOCTOR--------------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO DOCTOR
function ValidacionRegistroDoctor(){
    var nombredoc = document.getElementById("nombre_docag").value;
    var apellidosdoc = document.getElementById("apellidos_docag").value;
    var cedula = document.getElementById("cedula_docag").value;
    var genero = document.getElementById("genero_docag").value;
    var institucion = document.getElementById("institucionag").value;
    var foto = document.getElementById("foto_docag").value;
    var telefonodoc = document.getElementById("telefono_docag").value;
    var correo = document.getElementById("correo_docag").value;
    var contra = document.getElementById("contra_docag").value;
    var validacion_nombre = /\w+[a-z]/;
    var validacion_correo = /\w+@\w+\.+[a-z]/;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;


    if(nombredoc === "" || apellidosdoc === "" || telefonodoc === "" 
    || cedula === "" || genero === "" || institucion === "" || foto === "" || correo === ""
    || contra === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombredoc.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombredoc)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosdoc.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosdoc)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonodoc.length>10 || telefonodoc.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonodoc)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
    else if(institucion.length>25){
        alert("El nombre de la institucion es muy larga");
        return false;
    }else if(correo.length>100){
        alert("El correo es muy largo");
        return false;
    }
    else if(!validacion_correo.test(correo)){
        alert("El correo no tiene un formato valido");
        return false;
    }
    else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }else if(!validacion_clave.test(contra)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
//VALIDAR MODIFICACION DATOS DOCTOR
function ValidacionModDatosDoctor(){
    
    var nombredoc = document.getElementById("nombre_doc").value;
    var apellidosdoc = document.getElementById("apellidos_doc").value;
    var telefonodoc = document.getElementById("telefono_doc").value;
    var cedula = document.getElementById("cedula_doc").value;
    var institucion = document.getElementById("institucion").value;
    var validacion_nombre = /\w+[a-z]/;

    if(nombredoc === "" || apellidosdoc === "" || telefonodoc === "" || cedula === "" 
    || institucion === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombredoc.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombredoc)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosdoc.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosdoc)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonodoc.length>10 || telefonodoc.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonodoc)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
    else if(institucion.length>25){
        alert("El nombre de la institucion es muy larga");
        return false;
    }
}
function ValidacionModDatosDoctorAdmin(iddoc){
    
    var nombredoc = document.getElementById("nombre_docmad"+iddoc).value;
    var apellidosdoc = document.getElementById("apellidos_docmad"+iddoc).value;
    var telefonodoc = document.getElementById("telefono_docmad"+iddoc).value;
    var cedula = document.getElementById("cedula_docmad"+iddoc).value;
    var institucion = document.getElementById("institucionmad"+iddoc).value;
    var validacion_nombre = /\w+[a-z]/;
    console.log(nombredoc);
    console.log(iddoc);

    if(nombredoc === "" || apellidosdoc === "" || telefonodoc === "" || cedula === "" 
    || institucion === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombredoc.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombredoc)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosdoc.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosdoc)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonodoc.length>10 || telefonodoc.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonodoc)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
    else if(institucion.length>25){
        alert("El nombre de la institucion es muy larga");
        return false;
    }
}
//VALIDAR MODIFICACION FOTO DOCTOR
function ValidacionModFotoDoctor(){
    var foto = document.getElementById("foto_doc").value;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    if(foto === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
}
function ValidacionModFotoDoctorAdmin(iddoc){

    var foto = document.getElementById("foto_docmad"+iddoc).value;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    if(foto === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
}
//VALIDAR MODIFICACION CONTRA DOCTOR
function ValidacionModContraDoctor(){
    var clave_p,clave,clave2,validacion_clave;
    clave_p = document.getElementById("contra_actual").value;
    clave = document.getElementById("contra_nueva").value;
    clave2 = document.getElementById("contra_repetida").value;
    validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    if(clave_p === "" || clave === "" || clave2 === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(clave !== clave2){
        alert("Las Contraseñas no coinciden");
        return false;
    }else if(!validacion_clave.test(clave)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
function ValidacionModContraDoctorAdmin(iddoc){  
    var id=iddoc;
    var clave = document.getElementById('contra_nueva'+id).value;
    var clave2 = document.getElementById('contra_repetida'+id).value;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    console.log(clave);
    console.log(id);
    console.log(clave2);
    if(clave === "" || clave2=== ""){
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(clave !== clave2){
        alert("Las Contraseñas no coinciden");
        return false;
    }else if(!validacion_clave.test(clave)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}

/*---------------------------------------------------
-----------------------------------------------------
----------------------PACIENTE-----------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO PACIENTE
function ValidacionRegistroPaciente(){
    var nombreus = document.getElementById("nombre_us").value;
    var apellidosus = document.getElementById("apellidos_us").value;
    var telefonous = document.getElementById("telefono_us").value;
    var correo = document.getElementById("correo_us").value;
    var foto = document.getElementById("foto_us").value;
    var contrasena = document.getElementById("contrasena_us").value;
    console.log(contrasena);

    var validacion_nombre = /\w+[a-z]/;
    var validacion_correo = /\w+@\w+\.+[a-z]/;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;



    if(nombreus === "" || apellidosus === "" || telefonous === "" || correo === "" || foto === "" || contrasena === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombreus.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombreus)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosus.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosus)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonous.length>10 || telefonous.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonous)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }else if(correo.length>100){
        alert("El correo es muy largo");
        return false;
    }
    else if(!validacion_correo.test(correo)){
        alert("El correo no tiene un formato valido");
        return false;
    }
    else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
    else if(!validacion_clave.test(contrasena)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula Al menos una letra minusculas Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
function ValidacionRegistroPacienteAdmin(){
    var nombreus = document.getElementById("nombre_usadmin").value;
    var apellidosus = document.getElementById("apellidos_usadmin").value;
    var telefonous = document.getElementById("telefono_usadmin").value;
    var correo = document.getElementById("correo_usadmin").value;
    var foto = document.getElementById("foto_usadmin").value;
    var contrasena = document.getElementById("contrasena_usadmin").value;

    var validacion_nombre = /\w+[a-z]/;
    var validacion_correo = /\w+@\w+\.+[a-z]/;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;

    if(nombreus === "" || apellidosus === "" || telefonous === "" || correo === "" || foto === "" || contrasena === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!contrasena === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombreus.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombreus)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosus.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosus)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonous.length>10 || telefonous.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonous)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }else if(correo.length>100){
        alert("El correo es muy largo");
        return false;
    }
    else if(!validacion_correo.test(correo)){
        alert("El correo no tiene un formato valido");
        return false;
    }
    else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
    else if(!validacion_clave.test(contrasena)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula Al menos una letra minusculas Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
//VALIDAR MODIFICACION DATOS PACIENTE
function ValidacionModDatosPacienteAdmin(){
    var nombreus = document.getElementById("nombre_usm").value;
    var apellidosus = document.getElementById("apellidos_usm").value;
    var telefonous = document.getElementById("telefono_usm").value;
    var genero = document.getElementById("genero_usm").value;
    
    var validacion_nombre = /\w+[a-z]/;

    if(nombreus === "" || apellidosus === "" || telefonous === "" || genero === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombreus.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombreus)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosus.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosus)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonous.length>10 || telefonous.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonous)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
}
function ValidacionModDatosPaciente(){
    var nombreus = document.getElementById("nombre_us").value;
    var apellidosus = document.getElementById("apellidos_us").value;
    var telefonous = document.getElementById("telefono_us").value;
    var genero = document.getElementById("genero_us").value;
    
    var validacion_nombre = /\w+[a-z]/;

    if(nombreus === "" || apellidosus === "" || telefonous === "" || genero === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombreus.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombreus)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosus.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosus)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonous.length>10 || telefonous.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonous)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
}
//VALIDAR MODIFICACION FOTO PACIENTE
function ValidacionModFotoPacienteAdmin(){
    var foto = document.getElementById("fotous").value;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    console.log(foto);
    if(foto === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
}
//VALIDAR MODIFICACION CONTRA PACIENTE
function ValidacionModContraPacienteAdmin(){
    var claveus = document.getElementById("contrasenaus").value;
    var clave2us = document.getElementById("contrarepetida").value;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
   
    if(claveus === "" || clave2us === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(claveus !== clave2us){
        alert("Las Contraseñas no coinciden");
        return false;
    }else if(!validacion_clave.test(claveus)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
function ValidacionModContraPaciente(){
    var clave_p = document.getElementById("contra_actual").value;
    var clave = document.getElementById("contrasena_us").value;
    var clave2 = document.getElementById("contra_repeat").value;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    if(clave_p === "" || clave === "" || clave2 === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(clave !== clave2){
        alert("Las Contraseñas no coinciden");
        return false;
    }else if(!validacion_clave.test(clave)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
/*---------------------------------------------------
-----------------------------------------------------
----------------------ADMIN--------------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDAR MODIFICACION DATOS ADMIN 
function ValidacionModDatosAdmin(){
    var nombreus = document.getElementById("nombre_us").value;
    var apellidosus = document.getElementById("apellidos_us").value;
    var telefonous = document.getElementById("telefono_us").value;
    var genero = document.getElementById("genero_us").value;

    var validacion_nombre = /\w+[a-z]/;
    var validacion_correo = /\w+@\w+\.+[a-z]/;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;

    if(nombreus === "" || apellidosus === "" || telefonous === "" || genero === "" ){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombreus.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombreus)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(apellidosus.length>25){
        alert("El apellido es muy largo");
        return false;
    }
    else if(!validacion_nombre.test(apellidosus)){
        alert("El Apellido solo deve contener letras");
        return false;
    }else if(telefonous.length>10 || telefonous.length<10){
        alert("El Telefono deve contener 10 digitos");
        return false;
    }
    else if(isNaN(telefonous)){
        alert("El Telefono deve tener solo numeros");
        return false;
    }
} 
//VALIDAR MODIFICACION FOTO ADMIN
function ValidacionModFotoPaciente(){
    var foto = document.getElementById("foto_us").value;
    var validacion_imagen = /.*(png|jpg|jpeg|gif|JPG|PNG|JPEG|GIF)$/;
    if(foto === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_imagen.test(foto)){
        alert("Solo imagenes JPG PNG JPGE GIF ");
        return false;
    }
}
//VALIDAR MODIFICACION CONTRA ADMIN
function ValidacionModContraAdmin(){
    var clave_p = document.getElementById("contra_actual").value;
    var clave = document.getElementById("contrasena_us").value;
    var clave2 = document.getElementById("contra_repetida").value;
    var validacion_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    if(clave_p === "" || clave === "" || clave2 === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }
    else if(clave !== clave2){
        alert("Las Contraseñas no coinciden");
        return false;
    }else if(!validacion_clave.test(clave)){
        alert("La Clave deve tener Mínimo 8 caracteres Máximo 15 Al menos una letra mayúscula(A-Z),Al menos una letra minusculas(a-z), Al menos un dígito Sin espacios en blanco Al menos 1 caracter especial($@$!%*?&)");
        return false;
    }
}
/*---------------------------------------------------
-----------------------------------------------------
--------------------MEDICAMENTO----------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO MEDICAMENTO
function ValidacionRegistroMedicina(){
    var desmedicina = document.getElementById("des_medicina").value;
    var nombremedicina = document.getElementById("nombre_medicina").value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(desmedicina === "" || nombremedicina === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombremedicina.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombremedicina)){
        alert("El nombre solo deve contener letras");
        return false;
    }
}
//VALIDAR MODIFICACION MEDICAMENTO
function ValidacionModificarMedicina(id){
    var desmedicina = document.getElementById("descripcion_med"+id).value;
    var nombremedicina = document.getElementById("nombre_med"+id).value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(desmedicina === "" || nombremedicina === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(nombremedicina.length>25){
        alert("El nombre es muy largo");
        return false;
    }else if(!validacion_nombre.test(nombremedicina)){
        alert("El nombre solo deve contener letras");
        return false;
    }
    else if(!validacion_nombre.test(desmedicina)){
        alert("La descripcion solo deve contener letras");
        return false;
    }

}
/*---------------------------------------------------
-----------------------------------------------------
------------------------VIA--------------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO VIA
function ValidacionRegistroVia(){
    var viamed = document.getElementById("viamed").value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(viamed === "" ){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(viamed.length>25){
        alert("El nombre de la via es muy largo");
        return false;
    }else if(!validacion_nombre.test(viamed)){
        alert("La via solo deve contener letras");
        return false;
    }
}
//VALIDAR MODIFICACION VIA
function ValidacionModificarVia(id){
    var viamed = document.getElementById("viamed"+id).value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(viamed === "" ){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(viamed.length>25){
        alert("El nombre de la via es muy largo");
        return false;
    }else if(!validacion_nombre.test(viamed)){
        alert("La via solo deve contener letras");
        return false;
    }

}
/*---------------------------------------------------
-----------------------------------------------------
---------------------FORMAS--------------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO FORMAS
function ValidacionRegistroFormas(){
    var formamed = document.getElementById("formamed").value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(formamed === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(formamed.length>25){
        alert("El nombre de la forma es muy largo");
        return false;
    }else if(!validacion_nombre.test(formamed)){
        alert("El nombre de la forma solo deve contener letras");
        return false;
    }
}
//VALIDAR MODIFICACION FORMAS
function ValidacionModificarFormas(id){
    var formamed = document.getElementById("formamed"+id).value;
   
    var validacion_nombre = /\w+[a-z]/;


    if(formamed === ""){
        alert("Todos los campos son obligatorios"+formamed);
        return false;
    }else if(formamed.length>25){
        alert("El nombre de la forma es muy largo");
        return false;
    }else if(!validacion_nombre.test(formamed)){
        alert("El nombre de la forma solo deve contener letras");
        return false;
    }
}
/*---------------------------------------------------
-----------------------------------------------------
-------------------TRATAMIENTO-----------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO TRATAMIENTO
function ValidacionRegistroTratamiento(){
    var nombre_med = document.getElementById("nombre_med").value;
    var forma_med = document.getElementById("forma_med").value;
    var dosis_med = document.getElementById("dosis_med").value;
    var via_med = document.getElementById("via_med").value;
    var duracion_med = document.getElementById("duracion_med").value;
    var fecha_med = document.getElementById("fecha_med").value;
    var indicacion_med = document.getElementById("indicacion_med").value;
    var fre_med = document.getElementById("fre_med").value;

   
    var validacion_nombre = /\w+[a-z]/;
    var validacion_indicacion = /\w+[a-z]/;


    if(nombre_med === "" || forma_med === "" || dosis_med === "" || via_med === "" ||
    duracion_med === "" || fecha_med === "" || indicacion_med === "" || fre_med === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_nombre.test(indicacion_med)){
        alert("La indicacion solo deve contener letras");
        return false;
    }
}
//VALIDAR MODIFICACION TRATAMIENTO
function ValidacionModificarTratamiento(id){
    var nombre_med = document.getElementById("nombre_med"+id).value;
    var forma_med = document.getElementById("forma_med"+id).value;
    var dosis_med = document.getElementById("dosis_med"+id).value;
    var via_med = document.getElementById("via_med"+id).value;
    var duracion_med = document.getElementById("duracion_med"+id).value;
    var fecha_med = document.getElementById("fecha_med"+id).value;
    var indicacion_med = document.getElementById("indicacion_med"+id).value;
    var fre_med = document.getElementById("fre_med"+id).value;

   
    var validacion_nombre = /\w+[a-z]/;


    if(nombre_med === "" || forma_med === "" || dosis_med === "" || via_med === "" ||
    duracion_med === "" || fecha_med === "" || indicacion_med === "" || fre_med === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_nombre.test(indicacion_med)){
        alert("La indicacion solo deve contener letras");
        return false;
    }
}
/*---------------------------------------------------
-----------------------------------------------------
----------------------CITAS--------------------------
-----------------------------------------------------
-----------------------------------------------------*/ 
//VALIDA REGISTRO CITAS
function ValidacionRegistroCita(){
    var lugar_cita = document.getElementById("lugar_cita").value;
    var fecha_cita = document.getElementById("fecha_cita").value;
    var indi_cita = document.getElementById("indi_cita").value;
    
    var validacion_nombre = /\w+[a-z]/;


    if(lugar_cita === "" || fecha_cita === "" || indi_cita === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_nombre.test(indi_cita)){
        alert("La indicacion solo deve contener letras");
        return false;
    }
}
function ValidacionModificarCita(id){
    var lugar_cita = document.getElementById("lugar_cita"+id).value;
    var fecha_cita = document.getElementById("fecha_cita"+id).value;
    var indi_cita = document.getElementById("indi_cita"+id).value;
    var validacion_nombre = /\w+[a-z]/;
    if(lugar_cita === "" || fecha_cita === "" || indi_cita === ""){
        alert("Todos los campos son obligatorios");
        return false;
    }else if(!validacion_nombre.test(indi_cita)){
        alert("La indicacion solo deve contener letras");
        return false;
    }
}
//VALIDAR MODIFICACION CITAS

