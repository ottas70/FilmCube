<?php



try{
    //localhost
    //$db = new PDO("mysql:host=localhost;dbname=FilmCube;charset=utf8","root","root");
    //wa.toad.cz
    $db = new PDO("mysql:host=localhost;dbname=vodvaot1;charset=utf8","vodvaot1","********");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch (Exception $e){
    exit;
}
