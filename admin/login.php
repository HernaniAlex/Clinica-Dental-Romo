<?php
// Formulario de login administradores

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
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
            background: linear-gradient(135deg, #C8B299 0%, #676768 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }

        .login-header h1 {
            color: #676768;
            font-size: 1.5rem;
            margin-top: 0.5rem;
        }

        .login-header p {
            color: #999;
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .campo-login {
            margin-bottom: 1.5rem;
        }

        .campo-login label {
            display: block;
            margin-bottom: 0.5rem;
            color: #676768;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .campo-login input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .campo-login input:focus {
            outline: none;
            border-color: #C8B299;
            box-shadow: 0 0 0 3px rgba(200,178,153,0.2);
        }

        .boton-login {
            width: 100%;
            background: linear-gradient(135deg, #C8B299 0%, #676768 100%);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .boton-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(103,103,104,0.3);
        }

        .boton-login:active {
            transform: translateY(0);
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.8rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
            border: 1px solid #f5c6cb;
            font-size: 0.9rem;
        }

        .enlace-volver {
            text-align: center;
            margin-top: 1.5rem;
        }

        .enlace-volver a {
            color: #676768;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .enlace-volver a:hover {
            color: #C8B299;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }
            .login-header h1 {
                font-size: 1.3rem;
            }
            .login-header img {
                width: 60px;
                height: 60px;
            }
            .campo-login input {
                padding: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="/Clinica-Dental-Romo/assets/images/logo-dental.png" alt="Logo Clínica Dental Romo">
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

        <form action="/Clinica-Dental-Romo/controllers/auth_controller.php" method="POST">
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
            <a href="/Clinica-Dental-Romo/index.php"><i class="fas fa-arrow-left"></i> Volver a la página principal</a>
        </div>
    </div>
</body>
</html>