<?php
// Procesa el login del administrador

session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Comprobar existencia con isset
    if (isset($_POST["usuario"]) && isset($_POST["password"])) {
        
        // 2. Limpiar entradas
        $usuario = trim(strip_tags($_POST["usuario"]));
        $password = trim(strip_tags($_POST["password"]));
        
        $errores = [];
        
        // 3. Validaciones con patrones
        if ($usuario == "") {
            $errores[] = "El usuario es obligatorio";
        } else if (!preg_match("/^[a-zA-Z0-9_]{3,50}$/", $usuario)) {
            $errores[] = "El usuario solo puede contener letras, números y guión bajo (mínimo 3 caracteres)";
        }
        
        if ($password == "") {
            $errores[] = "La contraseña es obligatoria";
        }
        
        // 4. Si no hay errores, buscar en la base de datos
        if (empty($errores)) {
            
            $database = new Database();
            $db = $database->getConnection();
            
            // Buscar administrador por usuario
            $query = "SELECT id, usuario, password, nombre_completo, email 
                      FROM administradores 
                      WHERE usuario = :usuario";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar contraseña
                if (md5($password) == $admin['password']) {
                    
                    // Contraseña correcta - iniciar sesión
                    $_SESSION['admin_logueado'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_usuario'] = $admin['usuario'];
                    $_SESSION['admin_nombre'] = $admin['nombre_completo'];
                    
                    // Redirigir al dashboard
                    header("Location: ../admin/dashboard.php");
                    exit();
                    
                } else {
                    // Contraseña incorrecta
                    header("Location: ../admin/login.php?error=credenciales");
                    exit();
                }
            } else {
                // Usuario no existe
                header("Location: ../admin/login.php?error=credenciales");
                exit();
            }
            
        } else {
            // Errores de validacion
            header("Location: ../admin/login.php?error=credenciales");
            exit();
        }
        
    } else {
        // No se recibieron los datos
        header("Location: ../admin/login.php?error=credenciales");
        exit();
    }
    
} else {
    // Acceso directo al archivo sin POST
    header("Location: ../admin/login.php");
    exit();
}
?>