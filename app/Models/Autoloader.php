<?php


    spl_autoload_register(function ($class_name) {
        include 'models/' . $class_name . '.php';
    });
