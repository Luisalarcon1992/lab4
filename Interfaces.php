<?php
interface AgendaInterface {
    public function agregarEvento($nombre, $descripcion, $numero, $email);
    public function editarEvento($id, $nombre, $descripcion, $numero, $email);
    public function eliminarEvento($id);
    public function listarEventos();
    // Otros métodos CRUD o de negocio para Agenda
}

interface TareasInterface {
    public function agregarTarea($nombreTarea, $numeroTarea);
    public function editarTarea($id, $nombreTarea, $numeroTarea);
    public function eliminarTarea($id);
    public function listarTareas();
    // Otros métodos CRUD o de negocio para Tareas
}

interface RecordatorioInterface {
    public function agregarRecordatorio($nombreRecordatorio, $fechaInicio, $fechaFin);
    public function editarRecordatorio($id, $nombreRecordatorio, $fechaInicio, $fechaFin);
    public function eliminarRecordatorio($id);
    public function listarRecordatorios();
    public function calcularDiferenciaDias($fechaInicio, $fechaFin);
    // Otros métodos CRUD o de negocio para Recordatorio
    
}

?>
