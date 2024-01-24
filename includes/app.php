<?php 
require "funciones.php";
require "config/db.php";
require __DIR__ . "/../vendor/autoload.php";
use App\Propiedad;

$db = conectarDB();
Propiedad::setDB($db);
