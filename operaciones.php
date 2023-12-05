<?php
include 'ConexionDB.php';
include 'Interfaces.php';

class Agenda implements AgendaInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function agregarEvento($nombre, $descripcion, $numero, $email) {
        $stmt = $this->db->prepare("INSERT INTO agenda (nombre, descripcion, numero, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $descripcion, $numero, $email);
        $stmt->execute();
        $stmt->close();
    }

    public function listarEventos() {
        $result = $this->db->query("SELECT * FROM agenda");
        $eventos = $result->fetch_all(MYSQLI_ASSOC);
        return $eventos;
    }
    // Otras operaciones específicas de la agenda
}

// Crear una instancia de la clase Agenda con la conexión a la base de datos
$conexionDB = ConexionDB::obtenerConexion();
$agenda = new Agenda($conexionDB);

// Ejemplo de uso: Agregar un evento a la agenda
$agenda->agregarEvento("Reunión", "Planificación del proyecto", "123456", "correo@ejemplo.com");

// Ejemplo de uso: Listar eventos de la agenda
$eventos = $agenda->listarEventos();
print_r($eventos);

// Continuar con la implementación para Tareas y Recordatorio de manera similar
// ...

class Tareas implements TareasInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function agregarTarea($nombreTarea, $numeroTarea) {
        $stmt = $this->db->prepare("INSERT INTO tareas (nombreTarea, numeroTarea) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombreTarea, $numeroTarea);
        $stmt->execute();
        $stmt->close();
    }

    public function listarTareas() {
        $result = $this->db->query("SELECT * FROM tareas");
        $tareas = $result->fetch_all(MYSQLI_ASSOC);
        return $tareas;
    }
    // Otras operaciones específicas de las tareas
    public function editarEvento($id, $nombre, $descripcion, $numero, $email) {
        $stmt = $this->db->prepare("UPDATE agenda SET nombre=?, descripcion=?, numero=?, email=? WHERE id=?");
        $stmt->bind_param("ssssi", $nombre, $descripcion, $numero, $email, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarEvento($id) {
        $stmt = $this->db->prepare("DELETE FROM agenda WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function editarTarea($id, $nombreTarea, $numeroTarea) {
        $stmt = $this->db->prepare("UPDATE tareas SET nombreTarea=?, numeroTarea=? WHERE id=?");
        $stmt->bind_param("ssi", $nombreTarea, $numeroTarea, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarTarea($id) {
        $stmt = $this->db->prepare("DELETE FROM tareas WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

class Recordatorio implements RecordatorioInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function agregarRecordatorio($nombreRecordatorio, $fechaInicio, $fechaFin) {
        $diferenciaDias = $this->calcularDiferenciaDias($fechaInicio, $fechaFin);

        $stmt = $this->db->prepare("INSERT INTO recordatorio (nombreRecordatorio, fechaInicio, fechaFin, diferenciaDias) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombreRecordatorio, $fechaInicio, $fechaFin, $diferenciaDias);
        $stmt->execute();
        $stmt->close();
    }

    public function listarRecordatorios() {
        $result = $this->db->query("SELECT * FROM recordatorio");
        $recordatorios = $result->fetch_all(MYSQLI_ASSOC);
        return $recordatorios;
    }

    private function calcularDiferenciaDias($fechaInicio, $fechaFin) {
        $diff = strtotime($fechaFin) - strtotime($fechaInicio);
        return abs(round($diff / 86400)); // 86400 segundos = 1 día
    }

    public function editarRecordatorio($id, $nombreRecordatorio, $fechaInicio, $fechaFin) {
        $diferenciaDias = $this->calcularDiferenciaDias($fechaInicio, $fechaFin);

        $stmt = $this->db->prepare("UPDATE recordatorio SET nombreRecordatorio=?, fechaInicio=?, fechaFin=?, diferenciaDias=? WHERE id=?");
        $stmt->bind_param("ssssi", $nombreRecordatorio, $fechaInicio, $fechaFin, $diferenciaDias, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarRecordatorio($id) {
        $stmt = $this->db->prepare("DELETE FROM recordatorio WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Crear una instancia de la clase Tareas con la conexión a la base de datos
$tareas = new Tareas($conexionDB);

// Ejemplo de uso: Agregar una tarea
$tareas->agregarTarea("Estudiar PHP", "1");

// Ejemplo de uso: Listar tareas
$tareasListadas = $tareas->listarTareas();
print_r($tareasListadas);

// Crear una instancia de la clase Recordatorio con la conexión a la base de datos
$recordatorio = new Recordatorio($conexionDB);

// Ejemplo de uso: Agregar un recordatorio
$recordatorio->agregarRecordatorio("Cumpleaños", "2023-01-01", "2023-01-05");

// Ejemplo de uso: Listar recordatorios
$recordatoriosListados = $recordatorio->listarRecordatorios();
print_r($recordatoriosListados);

?>
