<?php 
/* new file  
роутер для всех запросов по площадкам
*/

function route($method, $urlData, $formData) {
    header('Content-Type: application/json; charset=utf-8');


    // Получение всех площадок
    // Get /locations/getLocations
    if ($method === 'GET' && count($urlData) === 1 && $urlData[0] === "getLocations") { /* urldata - массив с адресом [getLocations] */
        $result = getLocations(); /* находится в database/locations.dao.php */
        echo json_encode($result);
        return;
    }

    // Добавление площадки
    // Post /locations/addLocation
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "addLocation") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true); /* сами данные */
        $file = $_FILES['locationImage'];
        if (isset($file) && !is_null($file)) {
            $locationImage = uploadLocationImage($file); /* получаем адрес до изображения, примерно uploads/acldjweDDkje.png*/
            // $leafImage = uploadLeafImage();
        }
        else { $locationImage = ""; }
        $result = addLocation($decoded_json, $locationImage); /* что-то еще с фото придумать */
        echo json_encode([
            "success" => true,
            "filename" => $locationImage
        ]);
        return;
    }


    
    // Перемещение площадки (изменение координат)
    // post /locations/moveLocation
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "moveLocation") {
        
        moveLocation($formData['location_id'], $formData['latitude'], $formData['longitude']); 
        
        echo json_encode([
            "success" => true
        ]);
        return;
    }

    

    // Изменение картинки площадки 
    // post /locations/changeImageOfLocation
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "changeImageOfLocation") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true); /* сами данные */
        $file = $_FILES['locationImage'];
        $locationImage = uploadLocationImage($file, $decoded_json); /* получаем адрес до изображения, примерно uploads/1-1.png*/
        // $leafImage = uploadLeafImage();
        $result = changeImageOfLocation($decoded_json['location_id'], $locationImage); /* что-то еще с фото придумать */
        echo json_encode([
            "success" => true,
            "filename" => $locationImage
        ]);
        return;
    }

    // редактирование площадки в целом 
    // post /locations/editLocation
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "editLocation") {
        editLocation($formData);
        echo json_encode([
            "success" => true
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