<?php
// Formulario de login administradores
session_start();

// Si ya esta logueado, redirigir al dashboard
if (isset($_SESSION['admin_logueado']) && $_SESSION['admin_logueado'] === true) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - Clínica Dental Romo</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            margin: 1rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #005f73;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .login-header i {
            font-size: 3rem;
            color: #0a9396;
        }

        .campo-login {
            margin-bottom: 1.5rem;
        }

        .campo-login label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: bold;
        }

        .campo-login input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .campo-login input:focus {
            outline: none;
            border-color: #0a9396;
        }

        .boton-login {
            width: 100%;
            background-color: #005f73;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .boton-login:hover {
            background-color: #0a9396;
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            border: 1px solid #f5c6cb;
        }

        .enlace-volver {
            text-align: center;
            margin-top: 1.5rem;
        }

        .enlace-volver a {
            color: #0a9396;
            text-decoration: none;
        }

        .enlace-volver a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-tooth"></i>
            <h1>Clínica Dental Romo</h1>
            <p>Acceso Administrador</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="mensaje-error">
                <i class="fas fa-exclamation-triangle"></i> 
                <?php 
                    if ($_GET['error'] == 'credenciales') {
                        echo "Usuario o contraseña incorrectos";
                    } elseif ($_GET['error'] == 'sesion') {
                        echo "Debes iniciar sesión para acceder";
                    }
                ?>
            </div>
        <?php endif; ?>

        <form action="../controllers/auth_controller.php" method="POST">
            <div class="campo-login">
                <label for="usuario"><i class="fas fa-user"></i> Usuario</label>
                <input type="text" name="usuario" id="usuario" required autofocus>
            </div>
            <div class="campo-login">
                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="boton-login">Iniciar sesión</button>
        </form>

        <div class="enlace-volver">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Volver a la página principal</a>
        </div>
    </div>
</body>
</html>