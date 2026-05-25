<?php
// Controlador para gestionar mensajes

session_start();
require_once '../config/database.php';
require_once '../models/MensajeContacto.php';

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: /clinica-dental-romo/admin/login.php?error=sesion");
    exit();
}

// Obtener accion de la URL
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

$database = new Database();
$db = $database->getConnection();
$mensajeModel = new MensajeContacto($db);

// Definir base URL para redirecciones
$base_url = '/clinica-dental-romo';

// Procesar acciones
if ($accion == 'marcar_leido' && $id) {
    $mensajeModel->id = $id;
    if ($mensajeModel->marcarLeido()) {
        header("Location: " . $base_url . "/admin/mensajes.php?msg=marcado");
    } else {
        header("Location: " . $base_url . "/admin/mensajes.php?error=error");
    }
    exit();
}
elseif ($accion == 'eliminar' && $id) {
    $mensajeModel->id = $id;
    if ($mensajeModel->eliminar()) {
        header("Location: " . $base_url . "/admin/mensajes.php?msg=eliminado");
    } else {
        header("Location: " . $base_url . "/admin/mensajes.php?error=error");
    }
    exit();
}
elseif ($accion == 'ver' && $id) {
    $mensajeModel->id = $id;
    $mensajeModel->obtenerPorId();
    
    // Si no esta leido, marcarlo como leido
    if ($mensajeModel->leido == 0) {
        $mensajeModel->marcarLeido();
    }
    
    // Mostrar vista detalle
    require_once __DIR__ . '/../admin/ver_mensaje.php';
    exit();
}
elseif ($accion == 'editar' && $id) {
    $mensajeModel->id = $id;
    $mensajeModel->obtenerPorId();
    
    // Mostrar vista edicion
    require_once __DIR__ . '/../admin/editar_mensaje.php';
    exit();
}
elseif ($accion == 'actualizar' && $id) {
    // Procesar la actualizacion del mensaje
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $mensajeModel->id = $id;
        $mensajeModel->nombre = trim(strip_tags($_POST['nombre']));
        $mensajeModel->email = trim(strip_tags($_POST['email']));
        $mensajeModel->telefono = trim(strip_tags($_POST['telefono']));
        $mensajeModel->mensaje = trim(strip_tags($_POST['mensaje']));
        
        // Validaciones
        $errores = [];
        
        if ($mensajeModel->nombre == "") {
            $errores[] = "El nombre es obligatorio";
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,100}$/", $mensajeModel->nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios";
        }
        
        if ($mensajeModel->email == "") {
            $errores[] = "El email es obligatorio";
        } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $mensajeModel->email)) {
            $errores[] = "El formato del email no es válido";
        }
        
        if ($mensajeModel->mensaje == "") {
            $errores[] = "El mensaje es obligatorio";
        } elseif (strlen($mensajeModel->mensaje) < 10) {
            $errores[] = "El mensaje debe tener al menos 10 caracteres";
        }
        
        if ($mensajeModel->telefono != "") {
            if (!preg_match("/^[679][0-9]{8}$/", $mensajeModel->telefono)) {
                $errores[] = "El teléfono debe tener 9 dígitos y empezar por 6, 7 o 9";
            }
        }
        
        if (empty($errores)) {
            if ($mensajeModel->actualizar()) {
                header("Location: " . $base_url . "/admin/mensajes.php?msg=actualizado");
                exit();
            } else {
                header("Location: " . $base_url . "/admin/mensajes.php?error=error");
                exit();
            }
        } else {
            // Guardar errores en sesion y volver al formulario
            $_SESSION['errores_edicion'] = $errores;
            $_SESSION['datos_form'] = $_POST;
            header("Location: " . $base_url . "/admin/editar_mensaje.php?id=$id&error=validacion");
            exit();
        }
    }
}
else {
    header("Location: " . $base_url . "/admin/mensajes.php");
    exit();
}
?>