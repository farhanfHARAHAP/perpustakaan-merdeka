<?php

// Connect to DB

$host = 'localhost';
$user = 'harahapp_maxy';
$password = 'maxy_academy';
$port = 3306;
$database = 'harahapp_maxy';

try{
    $conn = mysqli_connect(
        $host, $user, $password, $database, $port
    );
}catch(mysqli_sql_exception $e){
    header('Location: /../view/');
}

// Useful functions

function isNotBadPOSTRequest($key){
    for($i=0;$i<count($key);$i++){
        if(!isset($_POST[$key[$i]])){
            return false;
        }        
    }
    return true;
}

function getPOSTRequest($form){
    $array = array();
    for($i=0;$i<count($form);$i++){
        array_push($array, $_POST[$form[$i]]);
    }
    return $array;
}

function isNotBadGETRequest($key){
    for($i=0;$i<count($key);$i++){
        if(!isset($_GET[$key[$i]])){
            return false;
        }        
    }
    return true;
}

function getGETRequest($form){
    $array = array();
    for($i=0;$i<count($form);$i++){
        array_push($array, $_GET[$form[$i]]);
    }
    return $array;
}