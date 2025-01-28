<?php

function println($str) {
    echo $str . "<br>";
}

function parseJson($file) {
    $jsonData = file_get_contents($file);
    $data = json_decode($jsonData, true); 
    return $data;
}

function mailto($email){
    return "<a href=\"mailto:" . $email . "\">" . $email . "</a>";
}

function anchor($url){
    return "<a target=\"_blank\" href=\"" . $url . "\">" . $url . "</a>";
}

?>
