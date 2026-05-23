<?php
// Panel de administracion
session_start();

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}
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

        .sidebar {
            width: 260px;
            background-color: #005f73;
            color: white;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
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

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: block;
            padding: 0.8rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: #0a9396;
        }

        .sidebar-menu i {
            width: 25px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem;
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
        }

        .boton-logout:hover {
            background-color: #c82333;
        }

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
        }

        .tarjeta i {
            font-size: 2rem;
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

        .welcome-message {
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-tooth"></i>
            <h2>Clínica Dental Romo</h2>
            <p>Administración</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Mensajes contacto</a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> Citas</a></li>
            <li><a href="#"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Administradores</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <div class="info-admin">
                <span><i class="fas fa-user"></i> <?php echo isset($_SESSION['admin_nombre']) ? htmlspecialchars($_SESSION['admin_nombre']) : 'Administrador'; ?></span>
                <a href="logout.php" class="boton-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
        </div>

        <div class="tarjetas-dashboard">
            <div class="tarjeta">
                <i class="fas fa-envelope"></i>
                <h3>Mensajes de contacto</h3>
                <div class="numero">0</div>
            </div>
            <div class="tarjeta">
                <i class="fas fa-calendar-check"></i>
                <h3>Citas pendientes</h3>
                <div class="numero">0</div>
            </div>
            <div class="tarjeta">
                <i class="fas fa-concierge-bell"></i>
                <h3>Servicios activos</h3>
                <div class="numero">0</div>
            </div>
        </div>

        <div class="welcome-message">
            <h3>Bienvenido al panel de administración</h3>
            <p>Desde aquí podrás gestionar todos los aspectos de la clínica dental.</p>
            <p>📌 Próximamente: gestión de mensajes, citas y servicios.</p>
        </div>
    </div>
</body>
</html>