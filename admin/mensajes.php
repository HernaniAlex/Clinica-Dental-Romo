<?php
// Listado de mensajes de contacto

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
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

// Obtener mensaje de sesion
$mensaje = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'marcado') $mensaje = 'Mensaje marcado como leído';
    if ($_GET['msg'] == 'eliminado') $mensaje = 'Mensaje eliminado correctamente';
}
$error = isset($_GET['error']) ? 'Error al procesar la solicitud' : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #0a9396;
        }

        .sidebar-header i { font-size: 2.5rem; }
        .sidebar-header h2 { font-size: 1.2rem; margin-top: 0.5rem; }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li { margin-bottom: 0.5rem; }
        .sidebar-menu a {
            display: block;
            padding: 0.8rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.activo { background-color: #0a9396; }
        .sidebar-menu i { width: 25px; margin-right: 10px; }

        /* Contenido principal */
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

        .top-bar h1 { color: #005f73; font-size: 1.5rem; }

        .info-admin {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .boton-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
        }
        .boton-logout:hover { background-color: #c82333; }

        /* Mensajes de alerta */
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

        /* Tabla */
        .tabla-contenedor {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #005f73;
            font-weight: bold;
        }

        tr:hover { background-color: #f5f5f5; }

        .no-leido {
            background-color: #fff3cd;
            font-weight: bold;
        }

        .badge {
            background-color: #dc3545;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
        }

        .acciones a {
            margin-right: 0.5rem;
            text-decoration: none;
            font-size: 1.1rem;
        }

        .btn-ver { color: #0a9396; }
        .btn-leido { color: #28a745; }
        .btn-eliminar { color: #dc3545; }
        .btn-editar { color: #ffc107; }
        
        .texto-centro { text-align: center; }
        .sin-datos { padding: 3rem; text-align: center; color: #666; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            th, td { padding: 0.5rem; font-size: 0.8rem; }
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
            <li><a href="mensajes.php" class="activo"><i class="fas fa-envelope"></i> Mensajes contacto 
                <?php if ($totalNoLeidos > 0): ?>
                    <span class="badge"><?php echo $totalNoLeidos; ?></span>
                <?php endif; ?>
            </a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> Citas</a></li>
            <li><a href="#"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Administradores</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h1><i class="fas fa-envelope"></i> Mensajes de Contacto</h1>
            <div class="info-admin">
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador'); ?></span>
                <a href="logout.php" class="boton-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="mensaje-exito"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
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
                                        <span style="color: #dc3545;">No leído</span>
                                    <?php else: ?>
                                        <span style="color: #28a745;">Leído</span>
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
</body>
</html>