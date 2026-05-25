<?php
// Funciones comunes de validacion

function validarNombre($nombre) {
    $nombre = trim(strip_tags($nombre));
    if (empty($nombre)) {
        return ['valido' => false, 'mensaje' => 'El nombre es obligatorio'];
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,100}$/", $nombre)) {
        return ['valido' => false, 'mensaje' => 'El nombre solo puede contener letras y espacios (mínimo 2 caracteres)'];
    }
    return ['valido' => true, 'valor' => $nombre];
}

function validarEmail($email) {
    $email = trim(strip_tags($email));
    if (empty($email)) {
        return ['valido' => false, 'mensaje' => 'El email es obligatorio'];
    }
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        return ['valido' => false, 'mensaje' => 'El formato del email no es válido'];
    }
    return ['valido' => true, 'valor' => $email];
}

function validarTelefono($telefono) {
    $telefono = trim(strip_tags($telefono));
    if (empty($telefono)) {
        return ['valido' => true, 'valor' => ''];
    }
    if (!preg_match("/^[679][0-9]{8}$/", $telefono)) {
        return ['valido' => false, 'mensaje' => 'El teléfono debe tener 9 dígitos y empezar por 6, 7 o 9'];
    }
    return ['valido' => true, 'valor' => $telefono];
}

function validarMensaje($mensaje, $minimo = 10) {
    $mensaje = trim(strip_tags($mensaje));
    if (empty($mensaje)) {
        return ['valido' => false, 'mensaje' => 'El mensaje es obligatorio'];
    }
    if (strlen($mensaje) < $minimo) {
        return ['valido' => false, 'mensaje' => "El mensaje debe tener al menos $minimo caracteres"];
    }
    return ['valido' => true, 'valor' => $mensaje];
}

function validarUsuario($usuario) {
    $usuario = trim(strip_tags($usuario));
    if (empty($usuario)) {
        return ['valido' => false, 'mensaje' => 'El usuario es obligatorio'];
    }
    if (!preg_match("/^[a-zA-Z0-9_]{3,50}$/", $usuario)) {
        return ['valido' => false, 'mensaje' => 'El usuario solo puede contener letras, números y guión bajo (mínimo 3 caracteres)'];
    }
    return ['valido' => true, 'valor' => $usuario];
}

function validarPassword($password, $minimo = 4) {
    if (empty($password)) {
        return ['valido' => false, 'mensaje' => 'La contraseña es obligatoria'];
    }
    if (strlen($password) < $minimo) {
        return ['valido' => false, 'mensaje' => "La contraseña debe tener al menos $minimo caracteres"];
    }
    return ['valido' => true, 'valor' => $password];
}

function validarServicioNombre($nombre) {
    $nombre = trim(strip_tags($nombre));
    if (empty($nombre)) {
        return ['valido' => false, 'mensaje' => 'El nombre del servicio es obligatorio'];
    }
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,100}$/", $nombre)) {
        return ['valido' => false, 'mensaje' => 'El nombre solo puede contener letras y espacios (mínimo 3 caracteres)'];
    }
    return ['valido' => true, 'valor' => $nombre];
}

function validarDescripcion($descripcion, $minimo = 20) {
    $descripcion = trim(strip_tags($descripcion));
    if (empty($descripcion)) {
        return ['valido' => false, 'mensaje' => 'La descripción es obligatoria'];
    }
    if (strlen($descripcion) < $minimo) {
        return ['valido' => false, 'mensaje' => "La descripción debe tener al menos $minimo caracteres"];
    }
    return ['valido' => true, 'valor' => $descripcion];
}
?>