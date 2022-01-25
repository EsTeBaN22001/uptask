<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TaskController;
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

// Ver proyecto
$router->get('/proyect', [DashboardController::class, 'proyect']);

// PERFIL
$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);

// Cambiar el password
$router->get('/change-password', [DashboardController::class, 'changePassword']);
$router->post('/change-password', [DashboardController::class, 'changePassword']);

// API para las tareas
$router->get('/api/tasks', [TaskController::class, 'index']);
$router->post('/api/task/create', [TaskController::class, 'create']);
$router->post('/api/task/update', [TaskController::class, 'update']);
$router->post('/api/task/delete', [TaskController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();