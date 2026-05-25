<?php
// models/Servicio.php - Modelo para manejar servicios

class Servicio {
    private $conn;
    private $table_name = "servicios";

    public $id;
    public $nombre;
    public $descripcion;
    public $icono;
    public $orden;
    public $activo;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los servicios
    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY orden ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener solo servicios activos
    public function obtenerActivos() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE activo = 1 
                  ORDER BY orden ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un servicio por ID
    public function obtenerPorId() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->nombre = $row['nombre'];
            $this->descripcion = $row['descripcion'];
            $this->icono = $row['icono'];
            $this->orden = $row['orden'];
            $this->activo = $row['activo'];
            $this->fecha_creacion = $row['fecha_creacion'];
            return true;
        }
        return false;
    }

    // Contar servicios activos
    public function contarActivos() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Crear nuevo servicio
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      icono = :icono, 
                      orden = :orden";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->icono = htmlspecialchars(strip_tags($this->icono));
        $this->orden = htmlspecialchars(strip_tags($this->orden));
        
        // Bind de parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':icono', $this->icono);
        $stmt->bindParam(':orden', $this->orden);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar servicio
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      icono = :icono, 
                      orden = :orden,
                      activo = :activo
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->icono = htmlspecialchars(strip_tags($this->icono));
        $this->orden = htmlspecialchars(strip_tags($this->orden));
        $this->activo = htmlspecialchars(strip_tags($this->activo));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind de parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':icono', $this->icono);
        $stmt->bindParam(':orden', $this->orden);
        $stmt->bindParam(':activo', $this->activo);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar (borrado físico)
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cambiar estado (activar/desactivar)
    public function cambiarEstado() {
        $query = "UPDATE " . $this->table_name . " 
                  SET activo = :activo 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $this->activo);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>