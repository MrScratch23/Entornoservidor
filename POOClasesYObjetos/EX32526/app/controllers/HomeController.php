<?php
namespace RubenMolinaExamen\App\controllers;
use RubenMolinaExamen\App\models\IncidenciaModel;
use RubenMolinaExamen\Lib\SessionManager;

class HomeController extends Controller {

  public static function index() {
    SessionManager::iniciarSesion();
    
    if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    $usuario = SessionManager::estaAutentificado($_SESSION['usuario']);
    if (!$usuario) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    
    $model = new IncidenciaModel();
    $tickets = $model->obtenerTodos();
    $mediaHoras = $model->obtenerMediaHoras();
    $ticketsResueltos = 0;
    $ticketsPendientes = 0;
    $ticketsCurso = 0;


    foreach ($tickets as $ticket) {
        if ($ticket['estado'] === "Resuelta") {
            $ticketsResueltos++;
        }
        if ($ticket['estado'] === "En curso") {
            $ticketsCurso++;
        }
        if ($ticket['estado']=== "Pendiente") {
            $ticketsPendientes;
        }
    }



    $datos = [
        'tickets' => $tickets, 
        'mediaHoras' => $mediaHoras,
        'ticketsResueltos' => $ticketsResueltos,
        'ticketsPendientes' => $ticketsPendientes,
        'ticketsCurso' => $ticketsCurso,
        'usuario' => $_SESSION['usuario']
    ];

    self::mostrarVista('index_view', $datos);
}
    

   
}
?>