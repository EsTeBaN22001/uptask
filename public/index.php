<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use MVC\Router;
$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Crear cuenta
$router->get('/create-account', [LoginController::class, 'createAccount']);
$router->post('/create-account', [LoginController::class, 'createAccount']);

// Recuperar contraseña
$router->get('/forgot-password', [LoginController::class, 'forgotPassword']);
$router->post('/forgot-password', [LoginController::class, 'forgotPassword']);

// Asignar la nueva contraseña
$router->get('/reset-password', [LoginController::class, 'resetPassword']);
$router->post('/reset-password', [LoginController::class, 'resetPassword']);

// Mensaje de confirmación
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm-account', [LoginController::class, 'confirmAccount']);

// ZONA DE PROYECTOS
// Dashboard
$router->get('/dashboard', [DashboardController::class, 'index']);

// Crear proyecto
$router->get('/create-proyect', [DashboardController::class, 'createProyect']);
$router->post('/create-proyect', [DashboardController::class, 'createProyect']);

// Perfil
$router->get('/profile', [DashboardController::class, 'profile']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();