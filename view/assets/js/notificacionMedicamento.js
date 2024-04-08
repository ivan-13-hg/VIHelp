// notificacionMed.js
//console.log("notificacionMedicamento.js cargado.");

function checkForNotifications() {
  try {
    // Solicitar permisos de notificación
    Notification.requestPermission().then((permission) => {
      if (permission === "granted") {
        // Si se otorgan los permisos, realizar la solicitud AJAX
        $.ajax({
          url: "./controller/notificacionesMedicamento.php",
          type: "GET",
          dataType: "json",
          success: function (data) {
            //console.log(data);
            if (data.notifications && data.notifications.length > 0) {
              data.notifications.forEach(function (notification) {
                // Enviar mensaje al service worker
                navigator.serviceWorker.controller.postMessage({
                  idnoti: notification.idnoti,
                  action: 'showNotification',
                  nombremed: notification.nombremed,
                  indicaciones: notification.indicaciones,
                  fechatoma: notification.fechatoma,
                  aplazada: notification.aplazada,
                  ingerido: notification.ingerido
                });
              });
            }
          },
          error: function (error) {
            console.error("Error al obtener notificaciones:", error);
          },
          complete: function () {
            setTimeout(checkForNotifications, 1000);
          },
        });
      }
    });
  } catch (error) {
    console.error("Error en la verificación de notificaciones:", error);
  }
}

$(document).ready(function () {
  checkForNotifications();
});
