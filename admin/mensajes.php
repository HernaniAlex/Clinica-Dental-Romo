<?php
// Listado de mensajes de contacto

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../models/MensajeContacto.php';

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$mensajeModel = new MensajeContacto($db);
$stmt = $mensajeModel->obtenerTodos();
$totalNoLeidos = $mensajeModel->contarNoLeidos();

$mensaje = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'marcado') $mensaje = 'Mensaje marcado como leído';
    if ($_GET['msg'] == 'eliminado') $mensaje = 'Mensaje eliminado correctamente';
    if ($_GET['msg'] == 'actualizado') $mensaje = 'Mensaje actualizado correctamente';
}
$error = isset($_GET['error']) ? 'Error al procesar la solicitud' : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Mensajes de Contacto - Clínica Dental Romo</title>
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
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .boton-logout:hover {
            background-color: #c82333;
        }

        .mensaje-exito {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
        }

        .tabla-contenedor {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #676768;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .no-leido {
            background-color: #fff3cd;
            font-weight: bold;
        }

        .acciones a {
            margin-right: 0.5rem;
            text-decoration: none;
            font-size: 1.1rem;
        }

        .btn-ver {
            color: #0a9396;
        }

        .btn-editar {
            color: #ffc107;
        }

        .btn-leido {
            color: #28a745;
        }

        .btn-eliminar {
            color: #dc3545;
        }

        .sin-datos {
            padding: 3rem;
            text-align: center;
            color: #999;
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
            
            .tabla-contenedor {
                margin: 0 -0.5rem;
                border-radius: 0;
            }
            
            th, td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }
            
            .acciones a {
                font-size: 1rem;
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
                justify-content: center;
                flex-wrap: wrap;
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
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="mensajes.php" class="activo"><i class="fas fa-envelope"></i> Mensajes contacto 
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
            <h1><i class="fas fa-envelope"></i> Mensajes de Contacto</h1>
            <div class="info-admin">
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador'); ?></span>
                <a href="logout.php" class="boton-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="mensaje-exito"><i class="fas fa-check-circle"></i> <?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="mensaje-error"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <div class="tabla-contenedor">
            <?php if ($stmt->rowCount() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr class="<?php echo $row['leido'] == 0 ? 'no-leido' : ''; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['telefono'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars(substr($row['mensaje'], 0, 50)) . (strlen($row['mensaje']) > 50 ? '...' : ''); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_envio'])); ?></td>
                                <td>
                                    <?php if ($row['leido'] == 0): ?>
                                        <span style="color: #dc3545;"><i class="fas fa-envelope"></i> No leído</span>
                                    <?php else: ?>
                                        <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Leído</span>
                                    <?php endif; ?>
                                </td>
                                <td class="acciones">
                                    <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=ver&id=<?php echo $row['id']; ?>" class="btn-ver" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=editar&id=<?php echo $row['id']; ?>" class="btn-editar" title="Editar"><i class="fas fa-edit"></i></a>
                                    <?php if ($row['leido'] == 0): ?>
                                        <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=marcar_leido&id=<?php echo $row['id']; ?>" class="btn-leido" title="Marcar como leído" onclick="return confirm('¿Marcar este mensaje como leído?')"><i class="fas fa-check-circle"></i></a>
                                    <?php endif; ?>
                                    <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=eliminar&id=<?php echo $row['id']; ?>" class="btn-eliminar" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este mensaje?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="sin-datos">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p>No hay mensajes de contacto todavía</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('visible');
        });
        
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('visible');
                }
            });
        });
        
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