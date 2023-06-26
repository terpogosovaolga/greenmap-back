<?php
// Получить список пользователей
function getUsers() {
    $stmt = Connection::get()->query('select * from users');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

function getUsersByRole($role) {
    $stmt = Connection::get()->query('select * from users where role = '.$role);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}
// Удалить пользователя
function deleteUser($id) {
    $stmt = Connection::get()->query('delete from users where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Выдать пользователю права админа
function changeRoleOfUser($id, $role) {
    $stmt = Connection::get()->query('update users set role = '.$role.' where id = '.$id);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Зарегистрировать нового пользователя
function addUser($data) {
    // проверка на существующий логин
    $hashedPass = md5(md5(trim($data['password'])));
    $stmt = Connection::get()->query("insert into users (login, password, name, surname, patronymic, role) values ('".$data['login']."', '".$hashedPass."', '".$data['name']."', '".$data['surname']."', '".$data['patronymic']."', ".$data['role'].")");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
// Авторизовать пользователя
function auth($login, $pass) {
    $stmt = Connection::get()->query("select * from users where login = '".$login."'");
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    $user = $result[0];
    if($user) {
        if($user["password"] == md5(md5(trim($pass)))) {
            return (["success" => true, "role" => $user["role"], "id" => $user["id"]]);
        } else {
            return (["success" => false, "error" => "Wrong password"]);
        }
    }
    return (["success" => false, "error" => "User does not exits"]);
}
// Разлогинить пользователя
// function logout() {
//     if (isset($_COOKIE['id'])) {
        
//         return (["success" => true]); 
//     } else {
//         return (["success" => false, "error" => "No Cookies"]);
//     }
// }
// Вспомогательная функция для генерация случайной соли хеша
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}