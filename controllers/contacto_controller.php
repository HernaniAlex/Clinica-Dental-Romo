<?php
// controllers/contacto_controller.php
// Siguiendo la teoría: isset, strip_tags, trim, preg_match, y conexión a BD

// Incluir la conexión a la base de datos
require_once '../config/database.php';

$mensaje = "";
$tipo_mensaje = "";

// 1. Comprobar existencia con isset
if (isset($_POST["nombre"]) && isset($_POST["email"]) && isset($_POST["mensaje"])) {
    
    // 2. Limpiar entradas con strip_tags y trim
    $nombre = trim(strip_tags($_POST["nombre"]));
    $email = trim(strip_tags($_POST["email"]));
    $telefono = trim(strip_tags($_POST["telefono"]));
    $mensaje_texto = trim(strip_tags($_POST["mensaje"]));
    
    $errores = [];
    
    // 3. Validacion del nombre con patrón
    if ($nombre == "") {
        $errores[] = "El nombre es obligatorio";
    } else if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,100}$/", $nombre)) {
        $errores[] = "El nombre solo puede contener letras y espacios (mínimo 2 caracteres)";
    }
    
    // 4. Validacion del email con patrón
    if ($email == "") {
        $errores[] = "El email es obligatorio";
    } else if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $errores[] = "El formato del email no es válido";
    }
    
    // 5. Validacion del telefono con patrón (opcional)
    if ($telefono != "") {
        if (!preg_match("/^[679][0-9]{8}$/", $telefono)) {
            $errores[] = "El teléfono debe tener 9 dígitos y empezar por 6, 7 o 9";
        }
    }
    
    // 6. Validacion del mensaje con patrón
    if ($mensaje_texto == "") {
        $errores[] = "El mensaje es obligatorio";
    } else if (strlen($mensaje_texto) < 10) {
        $errores[] = "El mensaje debe tener al menos 10 caracteres";
    } else if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,;:!?¿¡()\-_@#\$%&*+=\/]{10,500}$/", $mensaje_texto)) {
        $errores[] = "El mensaje contiene caracteres no permitidos";
    }
    
    // 7. Si no hay errores, guardar en la base de datos
    if (empty($errores)) {
        
        // Crear conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();
        
        // Preparar la consulta SQL para guardar el mensaje
        $query = "INSERT INTO mensajes_contacto (nombre, email, telefono, mensaje) 
                  VALUES (:nombre, :email, :telefono, :mensaje)";
        
        $stmt = $db->prepare($query);
        
        // Bind de parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':mensaje', $mensaje_texto);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Mensaje enviado correctamente. ¡Gracias por contactar con nosotros!";
            $tipo_mensaje = "success";
            
            // Limpiar variables
            $nombre = $email = $telefono = $mensaje_texto = "";
        } else {
            $mensaje = "Error al guardar el mensaje. Por favor, inténtelo de nuevo.";
            $tipo_mensaje = "error";
        }
        
    } else {
        $mensaje = implode("<br>", $errores);
        $tipo_mensaje = "error";
    }
    
} else {
    $mensaje = "Error: No se recibieron los datos del formulario";
    $tipo_mensaje = "error";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesando formulario - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <style>
        .contenedor-mensaje {
            max-width: 600px;
            margin: 100px auto;
            padding: 2rem;
            text-align: center;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .mensaje {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }
        .mensaje.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .boton-volver {
            display: inline-block;
            background-color: #005f73;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .boton-volver:hover {
            background-color: #0a9396;
        }
    </style>
</head>
<body>
    <div class="contenedor-mensaje">
        <?php if ($tipo_mensaje == "success"): ?>
            <div class="mensaje success">
                <i class="fas fa-check-circle"></i> <?php echo $mensaje; ?>
            </div>
        <?php else: ?>
            <div class="mensaje error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <a href="../index.php" class="boton-volver">← Volver a la página principal</a>
    </div>
</body>
</html>