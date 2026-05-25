<?php
// Ver detalle de un servicio

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: /Clinica-Dental-Romo/admin/login.php?error=sesion");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Servicio - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #005f73 0%, #0a9396 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header {
            background-color: #005f73;
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 1.5rem; }
        .header a { color: white; text-decoration: none; font-size: 1.2rem; }
        .contenido { padding: 2rem; }
        .campo {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        .campo label {
            font-weight: bold;
            color: #005f73;
            display: block;
            margin-bottom: 0.5rem;
        }
        .campo .valor {
            color: #333;
            line-height: 1.5;
        }
        .icono-grande {
            font-size: 4rem;
            color: #005f73;
            text-align: center;
            margin-bottom: 1rem;
        }
        .badge-activo {
            background-color: #28a745;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }
        .badge-inactivo {
            background-color: #dc3545;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }
        .botones {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn-volver {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            text-align: center;
        }
        .btn-editar {
            background-color: #ffc107;
            color: #333;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            text-align: center;
        }
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .botones { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-concierge-bell"></i> Detalle del Servicio</h1>
            <a href="/Clinica-Dental-Romo/admin/servicios.php"><i class="fas fa-times"></i></a>
        </div>
        <div class="contenido">
            <div class="icono-grande">
                <i class="<?php echo htmlspecialchars($servicioModel->icono); ?>"></i>
            </div>

            <div class="campo">
                <label><i class="fas fa-tag"></i> Nombre</label>
                <div class="valor"><?php echo htmlspecialchars($servicioModel->nombre); ?></div>
            </div>

            <div class="campo">
                <label><i class="fas fa-align-left"></i> Descripción</label>
                <div class="valor"><?php echo nl2br(htmlspecialchars($servicioModel->descripcion)); ?></div>
            </div>

            <div class="campo">
                <label><i class="fas fa-sort-numeric-down"></i> Orden</label>
                <div class="valor"><?php echo $servicioModel->orden; ?></div>
            </div>

            <div class="campo">
                <label><i class="fas fa-toggle-on"></i> Estado</label>
                <div class="valor">
                    <?php if ($servicioModel->activo == 1): ?>
                        <span class="badge-activo"><i class="fas fa-check"></i> Activo</span>
                    <?php else: ?>
                        <span class="badge-inactivo"><i class="fas fa-times"></i> Inactivo</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="campo">
                <label><i class="fas fa-calendar"></i> Fecha de creación</label>
                <div class="valor"><?php echo date('d/m/Y H:i:s', strtotime($servicioModel->fecha_creacion)); ?></div>
            </div>

            <div class="botones">
                <a href="/Clinica-Dental-Romo/admin/servicios.php" class="btn-volver"><i class="fas fa-arrow-left"></i> Volver al listado</a>
                <a href="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=editar&id=<?php echo $servicioModel->id; ?>" class="btn-editar"><i class="fas fa-edit"></i> Editar servicio</a>
            </div>
        </div>
    </div>
</body>
</html>