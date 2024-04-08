/*if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('./view/assets/js/Service_Worker.js')
    .then(reg => console.log('Registro de SW exitoso', reg))
    .catch(err => console.warn('Error al tratar de registrar el sw', err))
}
*/
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('./Service_Worker.js', { scope: './' })
    .then(registration => {
      //console.log('Service Worker registrado con éxito:', registration);
    })
    .catch(error => {
      //console.error('Error al registrar el Service Worker:', error);
    });
}


