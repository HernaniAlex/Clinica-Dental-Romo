<?php
// Controlador para gestionar servicios

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Servicio.php';

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: /Clinica-Dental-Romo/admin/login.php?error=sesion");
    exit();
}

// Obtener accion de la URL
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

$database = new Database();
$db = $database->getConnection();
$servicioModel = new Servicio($db);

$base_url = '/Clinica-Dental-Romo';

// Procesar acciones
if ($accion == 'ver' && $id) {
    $servicioModel->id = $id;
    $servicioModel->obtenerPorId();
    require_once __DIR__ . '/../admin/ver_servicio.php';
    exit();
}
elseif ($accion == 'crear') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servicioModel->nombre = trim(strip_tags($_POST['nombre']));
        $servicioModel->descripcion = trim(strip_tags($_POST['descripcion']));
        $servicioModel->icono = trim(strip_tags($_POST['icono']));
        $servicioModel->orden = trim(strip_tags($_POST['orden']));
        
        $errores = [];
        
        if (empty($servicioModel->nombre)) {
            $errores[] = "El nombre es obligatorio";
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,100}$/", $servicioModel->nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios (mínimo 3 caracteres)";
        }
        
        if (empty($servicioModel->descripcion)) {
            $errores[] = "La descripción es obligatoria";
        } elseif (strlen($servicioModel->descripcion) < 20) {
            $errores[] = "La descripción debe tener al menos 20 caracteres";
        }
        
        if (empty($errores)) {
            if ($servicioModel->crear()) {
                header("Location: " . $base_url . "/admin/servicios.php?msg=creado");
                exit();
            } else {
                header("Location: " . $base_url . "/admin/servicios.php?error=error");
                exit();
            }
        } else {
            $_SESSION['errores_servicio'] = $errores;
            $_SESSION['datos_servicio'] = $_POST;
            header("Location: " . $base_url . "/admin/crear_servicio.php?error=validacion");
            exit();
        }
    } else {
        require_once __DIR__ . '/../admin/crear_servicio.php';
        exit();
    }
}
elseif ($accion == 'editar' && $id) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servicioModel->id = $id;
        $servicioModel->nombre = trim(strip_tags($_POST['nombre']));
        $servicioModel->descripcion = trim(strip_tags($_POST['descripcion']));
        $servicioModel->icono = trim(strip_tags($_POST['icono']));
        $servicioModel->orden = trim(strip_tags($_POST['orden']));
        $servicioModel->activo = isset($_POST['activo']) ? 1 : 0;
        
        $errores = [];
        
        if (empty($servicioModel->nombre)) {
            $errores[] = "El nombre es obligatorio";
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,100}$/", $servicioModel->nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios";
        }
        
        if (empty($servicioModel->descripcion)) {
            $errores[] = "La descripción es obligatoria";
        } elseif (strlen($servicioModel->descripcion) < 20) {
            $errores[] = "La descripción debe tener al menos 20 caracteres";
        }
        
        if (empty($errores)) {
            if ($servicioModel->actualizar()) {
                header("Location: " . $base_url . "/admin/servicios.php?msg=actualizado");
                exit();
            } else {
                header("Location: " . $base_url . "/admin/servicios.php?error=error");
                exit();
            }
        } else {
            $_SESSION['errores_servicio'] = $errores;
            $_SESSION['datos_servicio'] = $_POST;
            header("Location: " . $base_url . "/admin/editar_servicio.php?id=$id&error=validacion");
            exit();
        }
    } else {
        $servicioModel->id = $id;
        $servicioModel->obtenerPorId();
        require_once __DIR__ . '/../admin/editar_servicio.php';
        exit();
    }
}
elseif ($accion == 'eliminar' && $id) {
    $servicioModel->id = $id;
    if ($servicioModel->eliminar()) {
        header("Location: " . $base_url . "/admin/servicios.php?msg=eliminado");
    } else {
        header("Location: " . $base_url . "/admin/servicios.php?error=error");
    }
    exit();
}
elseif ($accion == 'toggle_estado' && $id) {
    $estado = isset($_GET['estado']) ? $_GET['estado'] : '';
    $servicioModel->id = $id;
    $servicioModel->activo = $estado;
    if ($servicioModel->cambiarEstado()) {
        header("Location: " . $base_url . "/admin/servicios.php?msg=estado_cambiado");
    } else {
        header("Location: " . $base_url . "/admin/servicios.php?error=error");
    }
    exit();
}
else {
    header("Location: " . $base_url . "/admin/servicios.php");
    exit();
}
?>