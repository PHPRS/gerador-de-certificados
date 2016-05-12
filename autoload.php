<?php 
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});