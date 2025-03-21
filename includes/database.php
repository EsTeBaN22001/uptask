<?php

$db = mysqli_connect('localhost', 'root', 'root', 'uptask');
// $db = mysqli_connect('sql201.infinityfree.com', 'if0_38568386', 'B72EU24DVmh', 'if0_38568386_uptask');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
