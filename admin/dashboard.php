<?php
// Panel de administracion

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

$database = new Database();
$db = $database->getConnection();

$mensajeModel = new MensajeContacto($db);
$totalNoLeidos = $mensajeModel->contarNoLeidos();
$stmt = $mensajeModel->obtenerTodos();
$totalMensajes = $stmt->rowCount();

$servicioModel = new Servicio($db);
$totalServiciosActivos = $servicioModel->contarActivos();
$stmtServicios = $servicioModel->obtenerTodos();
$totalServicios = $stmtServicios->rowCount();

$totalCitas = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
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
            background-color: #f5f5f5;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: #676768;
            color: white;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #C8B299;
        }

        .sidebar-header img {
            width: 200px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
            margin-top: 0.5rem;
            color: #C8B299;
        }

        .sidebar-header p {
            font-size: 0.8rem;
            color: #ccc;
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
            background-color: #C8B299;
            border-left-color: #676768;
        }

        .sidebar-menu a.activo {
            background-color: #C8B299;
            border-left-color: #676768;
            color: #676768;
        }

        .sidebar-menu i {
            width: 25px;
            margin-right: 10px;
        }

        .badge {
            background-color: #C8B299;
            color: #676768;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            margin-left: 0.5rem;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: all 0.3s;
        }

        /* Botón menú móvil */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: #676768;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .menu-toggle i {
            margin-right: 0.5rem;
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
            color: #676768;
            font-size: 1.5rem;
        }

        .info-admin {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-admin span {
            color: #676768;
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
            color: #C8B299;
            margin-bottom: 0.5rem;
        }

        .tarjeta h3 {
            color: #676768;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .tarjeta .numero {
            font-size: 2rem;
            font-weight: bold;
            color: #676768;
        }

        .tarjeta .subtexto {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.3rem;
        }

        .welcome-message {
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .welcome-message h3 {
            color: #676768;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            
            .sidebar.visible {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding-top: 4rem;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .tarjetas-dashboard {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.8rem;
                padding-top: 4rem;
            }
            
            .top-bar h1 {
                font-size: 1.2rem;
            }
            
            .info-admin {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .tarjeta {
                padding: 1rem;
            }
            
            .welcome-message {
                padding: 1rem;
            }
            
            .welcome-message h3 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i> Menú
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/Clinica-Dental-Romo/assets/images/logo1.png" alt="Logo Clínica Dental Romo">
            <h2>Panel de Administración</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="activo"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="mensajes.php"><i class="fas fa-envelope"></i> Mensajes contacto 
                <?php if ($totalNoLeidos > 0): ?>
                    <span class="badge"><?php echo $totalNoLeidos; ?></span>
                <?php endif; ?>
            </a></li>
            <li><a href="servicios.php"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
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

        <div class="tarjetas-dashboard">
            <div class="tarjeta">
                <i class="fas fa-envelope"></i>
                <h3>Mensajes de contacto</h3>
                <div class="numero"><?php echo $totalMensajes; ?></div>
                <div class="subtexto"><?php echo $totalNoLeidos; ?> no leídos</div>
            </div>
            <div class="tarjeta">
                <i class="fas fa-concierge-bell"></i>
                <h3>Servicios activos</h3>
                <div class="numero"><?php echo $totalServiciosActivos; ?></div>
                <div class="subtexto">Total: <?php echo $totalServicios; ?> servicios</div>
            </div>
        </div>

        <div class="welcome-message">
            <h3>Bienvenido, <?php echo isset($_SESSION['admin_nombre']) ? htmlspecialchars($_SESSION['admin_nombre']) : 'Administrador'; ?></h3>
            <p>Desde aquí podrás gestionar todos los aspectos de la clínica dental.</p>
            <p><i class="fa-solid fa-check"></i><strong> Módulos disponibles:</strong> Gestión de mensajes de contacto y servicios.</p>
            <hr style="margin: 1rem 0; border-color: #e2e8f0;">
            <p style="font-size: 0.9rem; color: #666;">
                <i class="fas fa-info-circle"></i> Último acceso: <?php echo date('d/m/Y H:i:s'); ?>
            </p>
        </div>
    </div>

    <script>
        // Toggle menu para movil
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('visible');
        });
        
        // Cerrar menu al hacer clic en un enlace
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('visible');
                }
            });
        });
        
        // Cerrar menu al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = menuToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('visible')) {
                    sidebar.classList.remove('visible');
                }
            }
        });
    </script>
</body>
</html>