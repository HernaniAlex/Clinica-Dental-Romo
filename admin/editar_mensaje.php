<?php
// Formulario para editar mensaje

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/MensajeContacto.php';

// Verificar que el administrador esta logueado
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php?error=sesion");
    exit();
}

// Obtener ID del mensaje
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if (!$id) {
    header("Location: mensajes.php?error=error");
    exit();
}

// Obtener datos del mensaje
$database = new Database();
$db = $database->getConnection();
$mensajeModel = new MensajeContacto($db);
$mensajeModel->id = $id;
$mensajeModel->obtenerPorId();

// Si hay errores de validacion, usar datos guardados en sesion
$errores = isset($_SESSION['errores_edicion']) ? $_SESSION['errores_edicion'] : [];
$datos = isset($_SESSION['datos_form']) ? $_SESSION['datos_form'] : [];

// Limpiar errores de sesion despues de usarlos
unset($_SESSION['errores_edicion']);
unset($_SESSION['datos_form']);

// Valores para el formulario
$nombre = isset($datos['nombre']) ? htmlspecialchars($datos['nombre']) : htmlspecialchars($mensajeModel->nombre);
$email = isset($datos['email']) ? htmlspecialchars($datos['email']) : htmlspecialchars($mensajeModel->email);
$telefono = isset($datos['telefono']) ? htmlspecialchars($datos['telefono']) : htmlspecialchars($mensajeModel->telefono);
$mensaje = isset($datos['mensaje']) ? htmlspecialchars($datos['mensaje']) : htmlspecialchars($mensajeModel->mensaje);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mensaje - Clínica Dental Romo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .header h1 {
            font-size: 1.5rem;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .contenido {
            padding: 2rem;
        }

        .campo {
            margin-bottom: 1.5rem;
        }

        .campo label {
            display: block;
            font-weight: bold;
            color: #005f73;
            margin-bottom: 0.5rem;
        }

        .campo input,
        .campo textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .campo input:focus,
        .campo textarea:focus {
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

        .mensaje-error ul {
            margin-left: 1.5rem;
        }

        .info-adicional {
            background-color: #e0fbfc;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #005f73;
        }

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

        .btn-guardar:hover {
            background-color: #0a9396;
        }

        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-cancelar:hover {
            background-color: #5a6268;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .botones {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-edit"></i> Editar Mensaje</h1>
            <a href="/Clinica-Dental-Romo/admin/mensajes.php"><i class="fas fa-times"></i></a>
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

            <div class="info-adicional">
                <i class="fas fa-info-circle"></i> <strong>ID del mensaje:</strong> <?php echo $id; ?>
                <br>
                <i class="fas fa-calendar"></i> <strong>Fecha original:</strong> <?php echo date('d/m/Y H:i', strtotime($mensajeModel->fecha_envio)); ?>
            </div>

            <form action="/Clinica-Dental-Romo/controllers/mensajes_controller.php?accion=actualizar&id=<?php echo $id; ?>" method="POST">
                <div class="campo">
                    <label for="nombre"><i class="fas fa-user"></i> Nombre *</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required>
                </div>

                <div class="campo">
                    <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
                </div>

                <div class="campo">
                    <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" value="<?php echo $telefono; ?>">
                </div>

                <div class="campo">
                    <label for="mensaje"><i class="fas fa-comment"></i> Mensaje *</label>
                    <textarea name="mensaje" id="mensaje" rows="6" required><?php echo $mensaje; ?></textarea>
                </div>

                <div class="botones">
                    <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Guardar cambios</button>
                    <a href="/Clinica-Dental-Romo/admin/mensajes.php" class="btn-cancelar"><i class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>