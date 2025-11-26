<?php
// INSTRUCCIÓN 1: Iniciar sesión para acceder a los usuarios guardados
session_start();
$errores = [];
$usuarios = $_SESSION['todos_usuarios'];

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// INSTRUCCIÓN 2: Obtener datos del formulario (email, password, recordar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email'])) ?? '';
    $password = $_POST['password'] ?? '';
    $recordar = $_POST['recordar'] ?? '';

// INSTRUCCIÓN 3: Validar campos vacíos - si vacío, redirigir a index.php?error=vacío
    if ($email === '') {
        $errores['email'] = "El campo no puede estar vacio.";
    }
    // INSTRUCCIÓN 4: Validar formato email - si inválido, redirigir a index.php?error=email
    if (!validarEmail($email)) {
        $errores['email'] = "Email invalido";
    }
        
  // mejor metodo de busca

// INSTRUCCIÓN 7: Buscar usuario con array_filter
$usuariosFiltrados = array_filter($usuarios, function($usuario) use ($email) {
    // Esta función se ejecuta para CADA usuario
    // Retorna true si el email coincide, false si no
    return $usuario['email'] === $email;
});

// INSTRUCCIÓN 8: Verificar si se encontró algún usuario
if (empty($usuariosFiltrados)) {
    $errores['email'] = "No existe el email para ese usuario";
} else {
    // array_filter devuelve un array, tomamos el primer elemento
    $usuarioEncontrado = reset($usuariosFiltrados);
}

// INSTRUCCIÓN 9: Validar contraseña si usuario existe
if (!empty($usuariosFiltrados) && $usuarioEncontrado['password'] !== $password) {
    $errores['password'] = "Contraseña incorrecta";
}

     if ($password === '') {
        $errores['password'] = "El campo no puede estar vacio.";
    }

     if ($email === '') {
        $errores['recordar'] = "Seleccione una opcion.";
    }

    if (count($usuarios) === 0) {
        $errores['usuarios'] = "No hay usuarios para mostrar.";
    }




}







// INSTRUCCIÓN 5: Obtener usuarios desde la sesión $_SESSION['todos_usuarios']


// INSTRUCCIÓN 6: Verificar que la sesión tiene usuarios, sino redirigir con error


// INSTRUCCIÓN 7: Buscar usuario por email en $_SESSION['todos_usuarios']


// INSTRUCCIÓN 8: Si usuario no existe, redirigir a index.php?error=no_existe


// INSTRUCCIÓN 9: Verificar contraseña (comparar plain text) - si incorrecta, redirigir a index.php?error=password


// INSTRUCCIÓN 10: Si todo correcto, guardar datos del usuario en nueva sesión: $_SESSION['usuario'] con email, nombre, rol


// INSTRUCCIÓN 11: Manejar cookie "recordar_usuario" - si marcó recordar, crear cookie por 30 días, sino eliminarla


// INSTRUCCIÓN 12: Registrar actividad en registro_actividad.csv: fecha_actual, email, "Inicio de sesión"


// INSTRUCCIÓN 13: Redirigir a dashboard.php


// INSTRUCCIÓN 14: Asegurarse de usar exit; después de cada header Location