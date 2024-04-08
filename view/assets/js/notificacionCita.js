
				// Función para mostrar notificación push utilizando push.js
			
				
        		function showNotificationCita(indicita,lugarcita,fechacita) {
					Push.create('Buen dia Tu proxima cita es en ' + lugarcita, {
						body: fechacita +'Estas son las indicaciones:' + indicita,
						timeout: 5000,
						onClick: function () {
							window.focus();
							this.close();
						}
					});
				
        		}
                
        // Función para obtener y mostrar notificaciones
        function checkForNotificationsCita() {
            $.ajax({
                url: './controller/notificacionesCitas.php',
                type: 'GET',
                dataType: 'json',
                success: function (datos) {
                    //console.log('Respuesta del servidor Citas:', datos);
    
                    if (datos.notificacion && datos.notificacion.length > 0) {
                        // Mostrar notificación para cada medicamento recibido
                        datos.notificacion.forEach(function (notification) {
                            showNotificationCita(notification.indicita,notification.lugarcita,notification.fechacita);
                        });
                    }
                },
                error: function (error) {
                    console.error('Error al obtener notificaciones:', error);
                },
                complete: function () {
                    // Realizar la verificación periódica cada 5 segundos (ajustar según sea necesario)
                    setTimeout(checkForNotificationsCita, 1000);
                }
            });
        }
    
        // Iniciar la verificación periódica de notificaciones
        $(document).ready(function () {
            checkForNotificationsCita();
        });
    	