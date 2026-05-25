<?php
// Formulario para crear nuevo servicio

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Servicio.php';

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}

$errores = isset($_SESSION['errores_servicio']) ? $_SESSION['errores_servicio'] : [];
$datos = isset($_SESSION['datos_servicio']) ? $_SESSION['datos_servicio'] : [];

unset($_SESSION['errores_servicio']);
unset($_SESSION['datos_servicio']);

$nombre = isset($datos['nombre']) ? htmlspecialchars($datos['nombre']) : '';
$descripcion = isset($datos['descripcion']) ? htmlspecialchars($datos['descripcion']) : '';
$icono = isset($datos['icono']) ? htmlspecialchars($datos['icono']) : 'fas fa-tooth';
$orden = isset($datos['orden']) ? intval($datos['orden']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Servicio - Clínica Dental Romo</title>
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
        .campo { margin-bottom: 1.5rem; }
        .campo label {
            display: block;
            font-weight: bold;
            color: #005f73;
            margin-bottom: 0.5rem;
        }
        .campo input, .campo textarea, .campo select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        .campo input:focus, .campo textarea:focus, .campo select:focus {
            outline: none;
            border-color: #0a9396;
        }
        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.8rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid #f5c6cb;
        }
        .mensaje-error ul { margin-left: 1.5rem; }
        .botones {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn-guardar {
            background-color: #005f73;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-guardar:hover { background-color: #0a9396; }
        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .btn-cancelar:hover { background-color: #5a6268; }
        .icono-preview {
            display: inline-block;
            font-size: 2rem;
            margin-top: 0.5rem;
            color: #005f73;
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
            <h1><i class="fas fa-plus-circle"></i> Nuevo Servicio</h1>
            <a href="/Clinica-Dental-Romo/admin/servicios.php"><i class="fas fa-times"></i></a>
        </div>
        <div class="contenido">
            <?php if (!empty($errores)): ?>
                <div class="mensaje-error">
                    <strong><i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:</strong>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/Clinica-Dental-Romo/controllers/servicios_controller.php?accion=crear" method="POST">
                <div class="campo">
                    <label for="nombre"><i class="fas fa-tag"></i> Nombre del servicio *</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required>
                </div>

                <div class="campo">
                    <label for="descripcion"><i class="fas fa-align-left"></i> Descripción *</label>
                    <textarea name="descripcion" id="descripcion" rows="6" required><?php echo $descripcion; ?></textarea>
                </div>

                <div class="campo">
                    <label for="icono"><i class="fas fa-icons"></i> Icono (clase FontAwesome)</label>
                    <input type="text" name="icono" id="icono" value="<?php echo $icono; ?>" placeholder="ej: fas fa-tooth">
                    <div class="icono-preview">
                        <i class="<?php echo $icono; ?>"></i> Vista previa
                    </div>
                </div>

                <div class="campo">
                    <label for="orden"><i class="fas fa-sort-numeric-down"></i> Orden de visualización</label>
                    <input type="number" name="orden" id="orden" value="<?php echo $orden; ?>" min="0">
                </div>

                <div class="botones">
                    <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Crear servicio</button>
                    <a href="/Clinica-Dental-Romo/admin/servicios.php" class="btn-cancelar"><i class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('icono').addEventListener('input', function() {
            document.querySelector('.icono-preview i').className = this.value;
        });
    </script>
</body>
</html>