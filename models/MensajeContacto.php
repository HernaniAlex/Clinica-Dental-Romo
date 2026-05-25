<?php
// Modelo para manejar mensajes de contacto

class MensajeContacto {
    private $conn;
    private $table_name = "mensajes_contacto";

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $mensaje;
    public $fecha_envio;
    public $leido;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los mensajes
    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY fecha_envio DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener un mensaje por ID
    public function obtenerPorId() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->nombre = $row['nombre'];
            $this->email = $row['email'];
            $this->telefono = $row['telefono'];
            $this->mensaje = $row['mensaje'];
            $this->fecha_envio = $row['fecha_envio'];
            $this->leido = $row['leido'];
            return true;
        }
        return false;
    }

    // Marcar mensaje como leido
    public function marcarLeido() {
        $query = "UPDATE " . $this->table_name . " 
                  SET leido = 1 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar mensaje
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Contar mensajes no leidos
    public function contarNoLeidos() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE leido = 0";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }

    // Actualizar mensaje
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, 
                      email = :email, 
                      telefono = :telefono, 
                      mensaje = :mensaje 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->mensaje = htmlspecialchars(strip_tags($this->mensaje));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind de parametros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':mensaje', $this->mensaje);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>