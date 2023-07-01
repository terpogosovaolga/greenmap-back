<?php
// Роутер для справочной информации
function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Получение информации о конкретном типе объектов
    // GET /species/getSpecies
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] == 'getSpecies') {
        $typeName = $urlData[0];
        $result = getSpecies();
        echo json_encode([
            "success" => true,
            "species" => $result
        ]);
        return;
    }

    // Редактирование
    // POST /species/editSpecies
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] == 'editSpecies') {
        $typeName = $urlData[0];
        $result = editSpecies($formData);
        echo json_encode([
            "success" => true,
        ]);
        return;
    }
    // Добавление
    // POST /species/addSpecies
    if ($method === 'POST' && count($urlData) === 1 && $urlData[0] == 'addSpecies') {
        
        $result = addSpecies($formData);
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
