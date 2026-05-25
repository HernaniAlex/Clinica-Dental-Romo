<?php
// Ver detalle de un mensaje
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mensaje - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
        .header a { color: white; text-decoration: none; }

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

        .mensaje-texto {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 0.5rem;
            white-space: pre-wrap;
        }

        .botones {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-volver {
            background-color: #6c757d;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-eliminar {
            background-color: #dc3545;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-editar {
            background-color: #ffc107;
            color: #333;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-editar:hover {
            background-color: #e0a800;
        }

        .btn-volver:hover { background-color: #5a6268; }
        .btn-eliminar:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-envelope"></i> Detalle del Mensaje</h1>
            <a href="mensajes.php"><i class="fas fa-times"></i></a>
        </div>
        <div class="contenido">
            <div class="campo">
                <label><i class="fas fa-user"></i> Nombre</label>
                <div class="valor"><?php echo htmlspecialchars($mensajeModel->nombre); ?></div>
            </div>
            <div class="campo">
                <label><i class="fas fa-envelope"></i> Email</label>
                <div class="valor"><?php echo htmlspecialchars($mensajeModel->email); ?></div>
            </div>
            <?php if ($mensajeModel->telefono): ?>
            <div class="campo">
                <label><i class="fas fa-phone"></i> Teléfono</label>
                <div class="valor"><?php echo htmlspecialchars($mensajeModel->telefono); ?></div>
            </div>
            <?php endif; ?>
            <div class="campo">
                <label><i class="fas fa-calendar"></i> Fecha de envío</label>
                <div class="valor"><?php echo date('d/m/Y H:i:s', strtotime($mensajeModel->fecha_envio)); ?></div>
            </div>
            <div class="campo">
                <label><i class="fas fa-comment"></i> Mensaje</label>
                <div class="mensaje-texto"><?php echo nl2br(htmlspecialchars($mensajeModel->mensaje)); ?></div>
            </div>
            <div class="botones">
                <a href="/Clinica-Dental-Romo/admin/mensajes.php" class="btn-volver">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
                <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=editar&id=<?php echo $id; ?>" class="btn-editar">
                    <i class="fas fa-edit"></i> Editar mensaje
                </a>
                <a href="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=eliminar&id=<?php echo $id; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este mensaje?')">
                    <i class="fas fa-trash"></i> Eliminar
                </a>
            </div>
        </div>
    </div>
</body>
</html>