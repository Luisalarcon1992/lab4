<?php
// Aquí debes manejar la lógica para agregar un evento a la Agenda

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario enviado mediante POST
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];

    // Realizar la conexión a la base de datos (utilizando la lógica que ya has implementado)
    include 'ConexionDB.php';
    $conexionDB = ConexionDB::obtenerConexion();

    // Verificar la conexión y realizar la inserción de datos en la tabla 'agenda'
    if ($conexionDB->connect_error) {
        $respuesta = array("error" => "Error de conexión: " . $conexionDB->connect_error);
        echo json_encode($respuesta);
    } else {
        // Preparar la consulta para insertar datos en la tabla 'agenda'
        $stmt = $conexionDB->prepare("INSERT INTO agenda (nombre, descripcion, numero, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $descripcion, $numero, $email);
        
        if ($stmt->execute()) {
            $respuesta = array("mensaje" => "Evento agregado correctamente");
            echo json_encode($respuesta);
        } else {
            $respuesta = array("error" => "Error al agregar el evento: " . $conexionDB->error);
            echo json_encode($respuesta);
        }

        $stmt->close();
    }
} else {
    // Si la solicitud no es de tipo POST, devolver un mensaje de error
    $respuesta = array("error" => "Solicitud incorrecta");
    echo json_encode($respuesta);
}
?>
