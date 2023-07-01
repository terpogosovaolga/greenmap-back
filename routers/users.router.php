<?php 
/* new file  
роутер для всех запросов по площадкам
*/

function route($method, $urlData, $formData) {
    // header('Content-Type: application/json');

    // Получение всех пользователей
    // Get /users/getUsers
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "getUsers") { 
        $result = getUsers(); /* находится в database/users.dao.php */
        echo json_encode($result);
        return;
    }

    
    // Получение всех пользователей с ролью
    // Get /users/getUsersByRole
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] === "getUsersByRole") { 
        $result = getUsersByRole($formData['role']); /* находится в database/users.dao.php */
        
        echo json_encode($result);
        return;
    }

    // Удаление пользователя
    // Post /users/deleteUser
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "deleteUser") {
        // deleteUser($id);
    }

    // Поменять права апользователю
    // Post /users/changeRoleOfUser
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "changeRoleOfUser") {

        // changeRoleOfUser($id, $archive)
    }
    

    
    // регистрация
    // Post /users/addUser
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "addUser")
    {
        $result = addUser($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // авторизация
    // Post /users/login
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "login") {
        // setcookie("sfdksdf", 1, time()+60*24*60*30, "/");
        $result = auth($formData['login'], $formData['password']);
        echo json_encode($result);
        return;
    }

    // разлогиниться
    // Get /users/logout
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "logout") {
        logout();
        echo json_encode([
            "success" => true,
        ]);
        return;
    }

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
?>