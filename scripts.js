document.addEventListener("DOMContentLoaded", function() {
    const agendaForm = document.getElementById('agendaForm');
    const tareasForm = document.getElementById('tareasForm');
    const recordatorioForm = document.getElementById('recordatorioForm');
    const agendaTable = document.getElementById('agendaTable');
    const tareasTable = document.getElementById('tareasTable');
    const recordatorioTable = document.getElementById('recordatorioTable');

    // Función para realizar una solicitud AJAX
    function hacerSolicitudAJAX(metodo, url, datos, callback) {
        console.log(metodo, url, datos, callback)
        var xhr = new XMLHttpRequest(); // Crear un objeto XMLHttpRequest
        xhr.open(metodo, url, true); // Configurar la solicitud

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Éxito en la solicitud
                var respuesta = JSON.parse(xhr.responseText);
                callback(respuesta); // Llamar al callback con la respuesta
            } else {
                // Error en la solicitud
                console.error('Error en la solicitud.');
            }
        };

        xhr.onerror = function() {
            // Error de red
            console.error('Error de red.');
        };

        // Si se envían datos, establecer encabezado apropiado y enviar los datos
        if (datos) {
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(datos));
        } else {
            xhr.send();
        }
    }

    // Función para manejar la respuesta y actualizar la tabla correspondiente
    function manejarRespuesta(respuesta, tabla) {
        // Limpiar la tabla antes de actualizarla
        tabla.innerHTML = '';

        // Llenar la tabla con los datos de la respuesta
        // Aquí puedes usar un bucle para crear filas y celdas HTML y mostrar los datos en la tabla
        // Ejemplo: 
        // for (var i = 0; i < respuesta.length; i++) {
        //     var fila = tabla.insertRow();
        //     var celda1 = fila.insertCell(0);
        //     var celda2 = fila.insertCell(1);
        //     // ...
        // }

        // Actualizar la interfaz con los datos recibidos
    }

    // Manejar el envío del formulario de Agenda
    agendaForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

        // Obtener los valores del formulario de Agenda
        var nombre = document.getElementById('nombre').value;
        var descripcion = document.getElementById('descripcion').value;
        var numero = document.getElementById('numero').value;
        var email = document.getElementById('email').value;

        // Crear objeto con los datos del formulario de Agenda
        var datosAgenda = {
            nombre: nombre,
            descripcion: descripcion,
            numero: numero,
            email: email
            // Agregar otros campos aquí según sea necesario
        };

        // Realizar la solicitud AJAX para agregar evento a la Agenda
        hacerSolicitudAJAX('POST', 'agregar_evento.php', datosAgenda, function(respuesta) {
            manejarRespuesta(respuesta, agendaTable); // Actualizar la tabla de Agenda con la respuesta
        });
    });

    // Manejar el envío del formulario de Lista de Tareas
    // Similar al manejo del formulario de Agenda

    // Manejar el envío del formulario de Recordatorio de Tareas
    // Similar al manejo del formulario de Agenda
});
