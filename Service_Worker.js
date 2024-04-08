//asignar un nombre y versión al cache
const CACHE_NAME = 'WebDeveloper',
  urlsToCache = [
    './',
    './index.php',
    './regist_serviceWorker.js',
    './view/assets/img/icon/xmen-512x512.png',
    './view/assets/img/icon/xmen-72x72.png'
  ]
//durante la fase de instalación, generalmente se almacena en caché los activos estáticos
self.addEventListener('install', (event) => {
  console.log('Intall registrado');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => 
        cache.addAll(urlsToCache).then(() => self.skipWaiting())
      )
      .catch(err => console.log('Falló registro de cache', err))
  );  
});
//una vez que se instala el SW, se activa y busca los recursos para hacer que funcione sin conexión
self.addEventListener('activate', event => {
  console.log('Activate registrado');
  const cacheWhitelist = [CACHE_NAME]
  event.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName)
            }
          })
        )
      })
      .then(() => self.clients.claim())
  );
});
// Service_Worker.js
//cuando el navegador recupera una url
self.addEventListener('fetch', event => {
  //console.log('fetch registrado');
  //Responder ya sea con el objeto en caché o continuar y buscar la url real
  event.respondWith(caches.match(event.request).then(res => {
        if (res) {
          //recuperar del cache
          return res
        }
        //recuperar de la petición a la url
        return fetch(event.request);
      })
  );
});

// Manejo de mensajes personalizados
self.addEventListener('message', (event) => {
  console.log('Mensaje recibido en el service worker:', event.data);
  const data = event.data;

  if (data.action === 'showNotification') {
    if(data.aplazada == 1 && data.ingerido == 1){
      const notificationOptions = {
        body: `ID notificación: ${data.idnoti} - ${data.fechatoma}\nIndicaciones: ${data.indicaciones}`,
        data: { idnoti: data.idnoti},
        actions: [
          { action: 'aplazar', title: "Aplazar 5 minutos" },
          { action: 'tomado', title: "Tomado" },
        ],

        icon: './view/assets/img/icon/v-72x72.png', 
      };
      self.registration.showNotification(`Toma tu medicamento: ${data.nombremed}`, notificationOptions)
      .then(() => {
        console.log('Notificación mostrada con éxito');
      })
      .catch((error) => {
        console.error('Error al mostrar la notificación:', error);
      });
    }else if (data.aplazada == 2){
      notificationOptions = {
        body: `ID notificación: ${data.idnoti} - ${data.fechatoma}\nIndicaciones: ${data.indicaciones}`,
        data: { idnoti: data.idnoti},
        actions: [
          { action: 'tomado', title: "Tomado" },
        ],
        icon: './view/assets/img/icon/v-72x72.png', 
      };
      self.registration.showNotification(`Toma tu medicamento: ${data.nombremed}`, notificationOptions)
      .then(() => {
        console.log('Notificación mostrada con éxito');
      })
      .catch((error) => {
        console.error('Error al mostrar la notificación:', error);
      });
    }
  }
});

self.addEventListener('push', (event) => {
  console.log('Push event received:', event);
  const data = event.data.json();
  console.log('Notification data:', data);
  if(data.aplazada == 1 && data.ingerido == 1){
    self.registration.showNotification(
      "Buen día, toma tu medicamento " + data.nombremed,
      {
        body: `id notificacion: ${data.idnoti}${data.fechatoma}Estas son las indicaciones:${data.indicaciones}`,
        data: { idnoti: data.idnoti},
        actions: [
          { action: 'aplazar', title: "Aplazar 5 minutos" },
          { action: 'tomado', title: "Tomado" },
        ],
      }
    );
  }else if(data.aplazada == 2){
    self.registration.showNotification(
      "Buen día, toma tu medicamento " + data.nombremed,
      {
        body: `id notificacion: ${data.idnoti}${data.fechatoma}Estas son las indicaciones:${data.indicaciones}`,
        data: { idnoti: data.idnoti},
        actions: [
          
          { action: 'tomado', title: "Tomado" },
        ],
      }
    );
  }
});

self.addEventListener('notificationclick', (event) => {
  const action = event.action || 'default';
  const idnoti = event.notification.data.idnoti;
  switch (action) {
    case 'aplazar':
      console.log(`Aplazar 5 minutos for notification id ${idnoti}`);
      // Puedes agregar tu lógica para aplazar aquí
      aplazarNoti(idnoti, 'aplazar');
      break;
    case 'tomado':
      console.log(`Medicamento tomado for notification id ${idnoti}`);
      // Puedes agregar tu lógica para marcar como tomado aquí
      aplazarNoti(idnoti, 'tomado');
      break;
    default:
      console.log(`Default action for notification id ${idnoti}`);
      break;
  }
  event.notification.close();
});

// Resto del código del service worker...
// service-worker.js
function aplazarNoti(idnoti,action){
  const formData = new URLSearchParams();
  formData.append('idnoti', idnoti);
  formData.append('action', action);
  fetch('./controller/ctrlBotonesNoti.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      
    },
    body: formData,
  })
  .then(response => response.text())
  .then(data => {
    console.log('Respuesta del servidor:', data);
    // Agrega lógica según la respuesta del servidor
  })
  .catch(error => {
    console.error('Error al actualizar la base de datos:', error);
  });
}




