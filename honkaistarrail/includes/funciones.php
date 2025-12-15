<?php
// includes/funciones.php

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function esAdmin() {
    return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
}

function redirigirSiNoLogueado($pagina = 'login.php') {
    if (!estaLogueado()) {
        header("Location: $pagina");
        exit();
    }
}

function sanitizarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function mostrarError($mensaje) {
    return '<div class="error-message">' . htmlspecialchars($mensaje) . '</div>';
}

function mostrarExito($mensaje) {
    return '<div class="success-message">' . htmlspecialchars($mensaje) . '</div>';
}
?>