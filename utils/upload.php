<?php
// Загрузка файлов на сервер
function upload() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
    return $_FILES['userfile']['name'];
}


function uploadLocationImage($file) {
    writeToServerLog($file['name']);
    $arr = explode(".", $file['name']);
    $extension = $arr[count($arr) - 1];
    if(strlen($extension) === 0) {
        writeToServerLog("photo is not updated");
        return $file["name"];
    }
    $uploaddir = 'uploads/';
    $name = generateRandomName(12);
    $uploadfile = $uploaddir . basename($name) . "." . $extension;
    move_uploaded_file($file['tmp_name'], $uploadfile);
    return $uploadfile;
}

function uploadTreeImage($file, $data) {
    writeToServerLog($file['name']);
    $arr = explode(".", $file['name']);
    $extension = $arr[count($arr) - 1];
    if(strlen($extension) === 0) {
        writeToServerLog("photo is not updated");
        return $file["name"];
    }
    $uploaddir = 'uploads/';
    $name = $data['id_area'] . '-' . $data['id_species'] . '-' . generateRandomName(8);
    $uploadfile = $uploaddir . basename($name) . "." . $extension;
    move_uploaded_file($file['tmp_name'], $uploadfile);
    return $uploadfile;
}

function uploadLeafImage() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['leafimg']['name']);
    move_uploaded_file($_FILES['leafimg']['tmp_name'], $uploadfile);
    return $_FILES['leafimg']['name'];
}
function uploadSchemaImage() {
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['schemaimg']['name']);
    move_uploaded_file($_FILES['schemaimg']['tmp_name'], $uploadfile);
    return $_FILES['schemaimg']['name'];
}



function generateRandomName($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
    }
?>