<?php

namespace Controllers;

use Model\Proyect;
use Model\User;
use MVC\Router;

class DashboardController {

	public static function index(Router $router) {

		// Obtener los proyectos del usuario con su id
		$proyects = Proyect::belongsTo('userId', $_SESSION['id']);

		$router->render('dashboard/index', [
			'title' => 'Proyectos',
			'proyects' => $proyects,
		]);

	}

	public static function createProyect(Router $router) {

		$alerts = [];

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$proyect = new Proyect($_POST);

			// Validación del proyecto
			$alerts = $proyect->validateProyect();

			if (empty($alerts)) {

				// Generar una URL única para el proyecto
				$proyect->url = md5(uniqid());

				// debuguear($proyect);

				// Obtener el id del usuario que creó el proyecto
				$proyect->userId = $_SESSION['id'];

				$result = $proyect->save();

				if ($result) {
					header('Location: /proyect?url=' . $proyect->url);
				}

			}

		}

		$router->render('dashboard/create-proyect', [
			'title' => 'Crear proyecto',
			'alerts' => $alerts,
		]);

	}

	public static function proyect(Router $router) {

		// Revisar que la persona que visita el proyecto es quien lo creó
		// Obtener url/token/id del proyecto
		$url = $_GET['url'];

		// Si no hay un token redireccionar al usuario
		if (!$url) {
			header('Location: /dashboard');
		}

		// Buscar el proyecto por su url/id
		$proyect = Proyect::where('url', $url);

		if ($proyect->userId !== $_SESSION['id']) {
			header('Location: /dashboard');
		}

		$router->render('dashboard/proyect', [
			'title' => $proyect->proyect,
		]);

	}

	public static function profile(Router $router) {

		// Array con las alertas
		$alerts = [];

		// Obtener una instania del usuario autenticado
		$user = User::find($_SESSION['id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user->syncUp($_POST);

			// Validar los datos del formulario
			$alerts = $user->validateProfile();

			if (empty($alerts)) {

				$userExists = User::where('email', $user->email);

				if ($userExists && $userExists->id !== $user->id) {
					User::setAlert('error', 'El correo ya está registrado');
				} else {

					$result = $user->save();

					if ($result) {

						User::setAlert('success', 'Se guardó correctamente');

						$_SESSION['name'] = $user->name;
						$_SESSION['email'] = $user->email;

					} else {
						User::setAlert('error', 'Hubo un error');
					}

				}

			}

		}

		$alerts = $user->getAlerts();

		$router->render('dashboard/profile', [
			'title' => 'Perfil',
			'alerts' => $alerts,
			'user' => $user,
		]);

	}

	public static function changePassword(Router $router) {

		// Array de alertas
		$alerts = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user = User::find($_SESSION['id']);

			$user->syncUp($_POST);

			$alerts = $user->newPassword();

			if (empty($alerts)) {

				$verifyPassword = $user->verifyPassword();

				if ($verifyPassword) {

					$user->password = $user->newPassword;

					unset($user->actualPassword);
					unset($user->newPassword);

					$user->hashPassword();

					$result = $user->save();

					if ($result) {
						User::setAlert('success', 'Contraseña guardada correctamente');
					}

				} else {
					User::setAlert('error', 'Contraseña incorrecta');
				}

			}

			$alerts = $user::getAlerts();

		}

		$router->render('dashboard/change-password', [
			'title' => 'Cambiar contraseña',
			'alerts' => $alerts,
		]);

	}

	public static function changeKeyword(Router $router) {

		$alerts = [];

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$user = User::find($_SESSION['id']);

			$user->syncUp($_POST);

			$alerts = $user->validateKeyword();

			if (empty($alerts)) {

				$user->hashKeyword();

				$result = $user->save();

				debuguear($user);

				if ($result) {
					User::setAlert('success', 'Contraseña guardada correctamente');
				} else {
					User::setAlert('error', 'Hubo un problema, intente de nuevo');
				}

			}

		}

		$alerts = User::getAlerts();

		$router->render('dashboard/change-keyword', [
			'title' => 'Cambiar palabra clave',
			'alerts' => $alerts,
		]);

	}

}

?>