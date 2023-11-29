<?php

$db = mysqli_connect('sql300.infinityfree.com', 'if0_35519537', 'v5hD2WHB0KoULRr', 'if0_35519537_uptask');

if (!$db) {
	echo "Error: No se pudo conectar a MySQL.";
	echo "errno de depuración: " . mysqli_connect_errno();
	echo "error de depuración: " . mysqli_connect_error();
	exit;
}