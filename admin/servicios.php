<?php
// Listado de servicios

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Servicio.php';

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$servicioModel = new Servicio($db);
$stmt = $servicioModel->obtenerTodos();
$totalActivos = $servicioModel->contarActivos();

$mensaje = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'creado') $mensaje = 'Servicio creado correctamente';
    if ($_GET['msg'] == 'actualizado') $mensaje = 'Servicio actualizado correctamente';
    if ($_GET['msg'] == 'eliminado') $mensaje = 'Servicio eliminado correctamente';
    if ($_GET['msg'] == 'estado_cambiado') $mensaje = 'Estado del servicio cambiado';
}
$error = isset($_GET['error']) ? 'Error al procesar la solicitud' : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
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
        .boton-crear {
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .boton-crear:hover { background-color: #218838; }
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
        .badge-activo {
            background-color: #28a745;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        .badge-inactivo {
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
        .btn-editar { color: #ffc107; }
        .btn-eliminar { color: #dc3545; }
        .btn-activar { color: #28a745; }
        .sin-datos { padding: 3rem; text-align: center; color: #666; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
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
            <li><a href="mensajes.php"><i class="fas fa-envelope"></i> Mensajes contacto</a></li>
            <li><a href="servicios.php" class="activo"><i class="fas fa-concierge-bell"></i> Servicios</a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> Citas</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Administradores</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h1><i class="fas fa-concierge-bell"></i> Gestión de Servicios</h1>
            <div class="info-admin">
                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador'); ?></span>
                <a href="logout.php" class="boton-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
        </div>

        <div style="margin-bottom: 1rem; text-align: right;">
            <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=crear" class="boton-crear">
                <i class="fas fa-plus"></i> Nuevo Servicio
            </a>
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
                            <th>Icono</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Orden</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><i class="<?php echo htmlspecialchars($row['icono']); ?>"></i></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars(substr($row['descripcion'], 0, 60)) . (strlen($row['descripcion']) > 60 ? '...' : ''); ?></td>
                                <td><?php echo $row['orden']; ?></td>
                                <td>
                                    <?php if ($row['activo'] == 1): ?>
                                        <span class="badge-activo">Activo</span>
                                    <?php else: ?>
                                        <span class="badge-inactivo">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="acciones">
                                    <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=ver&id=<?php echo $row['id']; ?>" class="btn-ver" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=editar&id=<?php echo $row['id']; ?>" class="btn-editar" title="Editar"><i class="fas fa-edit"></i></a>
                                    <?php if ($row['activo'] == 1): ?>
                                        <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=toggle_estado&id=<?php echo $row['id']; ?>&estado=0" class="btn-activar" title="Desactivar" onclick="return confirm('¿Desactivar este servicio?')"><i class="fas fa-toggle-on"></i></a>
                                    <?php else: ?>
                                        <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=toggle_estado&id=<?php echo $row['id']; ?>&estado=1" class="btn-activar" title="Activar" onclick="return confirm('¿Activar este servicio?')"><i class="fas fa-toggle-off"></i></a>
                                    <?php endif; ?>
                                    <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=eliminar&id=<?php echo $row['id']; ?>" class="btn-eliminar" title="Eliminar" onclick="return confirm('¿Eliminar este servicio permanentemente?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="sin-datos">
                    <i class="fas fa-concierge-bell" style="font-size: 3rem; color: #ccc;"></i>
                    <p>No hay servicios creados todavía</p>
                    <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=crear" class="boton-crear" style="margin-top: 1rem;">Crear primer servicio</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>