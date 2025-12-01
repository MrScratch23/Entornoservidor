<?php

require_once 'includes/config.php';

require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();
$mensaje = "null";
$tipo_mensaje = "";




$lista_productos = $productoModel->obtenerTodos();

require_once APP_ROOT . '/views/index_view.php';


?>