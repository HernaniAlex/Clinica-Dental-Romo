<?php
// Panel de administracion

// Activar errores para depurar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}

// Incluir conexion a la base de datos y modelos
require_once '../config/database.php';
require_once '../models/MensajeContacto.php';
require_once '../models/Servicio.php';

// Crear objetos para obtener datos reales
$database = new Database();
$db = $database->getConnection();

// Contar mensajes
$mensajeModel = new MensajeContacto($db);
$totalNoLeidos = $mensajeModel->contarNoLeidos();
$stmt = $mensajeModel->obtenerTodos();
$totalMensajes = $stmt->rowCount();

// Contar servicios activos
$servicioModel = new Servicio($db);
$totalServiciosActivos = $servicioModel->contarActivos();

// Contar total de servicios
$stmtServicios = $servicioModel->obtenerTodos();
$totalServicios = $stmtServicios->rowCount();

// Contador para citas
$totalCitas = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: #005f73;
            color: white;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #0a9396;
        }

        .sidebar-header i {
            font-size: 2.5rem;
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        .sidebar-header p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 0.3rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.2rem;
        }

        .sidebar-menu a {
            display: block;
            padding: 0.8rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover {
            background-color: #0a9396;
            border-left-color: #ee9b00;
        }

        .sidebar-menu a.activo {
            background-color: #0a9396;
            border-left-color: #ee9b00;
        }

        .sidebar-menu i {
            width: 25px;
            margin-right: 10px;
        }

        .badge {
            background-color: #dc3545;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            margin-left: 0.5rem;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            transition: all 0.3s;
        }

        .top-bar {
            background-color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .top-bar h1 {
            color: #005f73;
            font-size: 1.5rem;
        }

        .info-admin {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-admin span {
            color: #333;
        }

        .boton-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .boton-logout:hover {
            background-color: #c82333;
        }

        /* Tarjetas */
        .tarjetas-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .tarjeta {
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .tarjeta:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .tarjeta i {
            font-size: 2.5rem;
            color: #005f73;
            margin-bottom: 0.5rem;
        }

        .tarjeta h3 {
            color: #333;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .tarjeta .numero {
            font-size: 2rem;
            font-weight: bold;
            color: #005f73;
        }

        .tarjeta .subtexto {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.3rem;
        }

        .welcome-message {
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-message h3 {
            color: #005f73;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .top-bar {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .tarjetas-dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-tooth"></i>
            <h2>Clínica Dental Romo</h2>
            <p>Panel de Administración</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="activo"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="mensajes.php"><i class="fas fa-envelope"></i> Mensajes contacto 
                <?php if ($totalNoLeidos > 0): ?>
                    <span class="badge"><?php echo $totalNoLeidos; ?></span>
                <?php endif; ?>
            </a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> Citas</a></li>
            <li><a href="servicios.php"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Administradores</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="top-bar">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <div class="info-admin">
                <span><i class="fas fa-user-circle"></i> <?php echo isset($_SESSION['admin_nombre']) ? htmlspecialchars($_SESSION['admin_nombre']) : 'Administrador'; ?></span>
                <a href="logout.php" class="boton-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
        </div>

        <!-- Tarjetas de estadisticas -->
        <div class="tarjetas-dashboard">
            <div class="tarjeta">
                <i class="fas fa-envelope"></i>
                <h3>Mensajes de contacto</h3>
                <div class="numero"><?php echo $totalMensajes; ?></div>
                <div class="subtexto"><?php echo $totalNoLeidos; ?> no leídos</div>
            </div>
            <div class="tarjeta">
                <i class="fas fa-calendar-check"></i>
                <h3>Citas pendientes</h3>
                <div class="numero"><?php echo $totalCitas; ?></div>
                <div class="subtexto">Próximamente</div>
            </div>
            <div class="tarjeta">
                <i class="fas fa-concierge-bell"></i>
                <h3>Servicios activos</h3>
                <div class="numero"><?php echo $totalServiciosActivos; ?></div>
                <div class="subtexto">Total: <?php echo $totalServicios; ?> servicios</div>
            </div>
        </div>

        <!-- Mensaje de bienvenida -->
        <div class="welcome-message">
            <h3><i class="fas fa-smile-wink"></i> Bienvenido, <?php echo isset($_SESSION['admin_nombre']) ? htmlspecialchars($_SESSION['admin_nombre']) : 'Administrador'; ?></h3>
            <p>Desde aquí podrás gestionar todos los aspectos de la clínica dental.</p>
            <p>✅ <strong>Módulos disponibles:</strong> Gestión de mensajes de contacto y servicios.</p>
            <p>📌 <strong>Próximamente:</strong> Gestión de citas y administradores.</p>
            <hr style="margin: 1rem 0; border-color: #e2e8f0;">
            <p style="font-size: 0.9rem; color: #666;">
                <i class="fas fa-info-circle"></i> Último acceso: <?php echo date('d/m/Y H:i:s'); ?>
            </p>
        </div>
    </div>
</body>
</html>