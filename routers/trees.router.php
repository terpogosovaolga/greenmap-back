<?php 
/* new file  
роутер для всех запросов по площадкам
*/

function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    // Получение деревьев на площадке 
    // Get /trees/getTrees/{location_id}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === "getTrees") { 
        $result = getTreesInLocation($urlData[1]); /* находится в database/trees.dao.php */
        echo json_encode($result);
        return;
    }

    // Добавление дерева
    // Post /trees/addTree
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "addTree") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true); /* сами данные */
        $file = $_FILES['treeImage'];
        if (isset($file) && !is_null($file)) {
            $treeImage = uploadTreeImage($file, $decoded_json); /* получаем адрес до изображения, примерно uploads/1-1.png*/
        // $leafImage = uploadLeafImage();
        }
        else { $treeImage = ""; }
        // $leafImage = uploadLeafImage();
        $result = addTree($decoded_json, $treeImage); /* что-то еще с фото придумать */
        echo json_encode([
            "success" => true,
            "filename" => $treeImage
        ]);
        return;
    }

    // Добавление деревьев JSON
    // Post /trees/addFewTrees
    if ($method == 'POST' && count($urlData) === 1 && $urlData[0] === "addFewTrees") {
        foreach ($formData['trees'] as $tree) {
            $words = explode(" ", $tree['name']);
            if (count($words) == 0) {
                $species = strtolower($tree['name']);
            }
            else {
                $species = strtolower($words[0]);
            }
            $sps = getSpeciesByName($species);
            if (count($sps) == 0) {
                $sql = addGlossaryDataName("species", $species);
                $ls = getSpeciesByName($species)[0]['id'];
            } else { $ls = $sps[0]['id']; }
            $tree['species'] = $ls;
            // $tree['id_location'] = $tree['location'];

            foreach ($tree as $k => $v) {
                if ($v === false) {
                    $tree[$k] = 0;
                } else if ($v === true) {
                    $tree[$v] = 1;
                }
            }

            addTree($tree, "uploads/".$tree['photo']);
        }
        echo json_encode([
            "success" => true
        ]);
        return;
    }

    // Фильтрация
    // HELP

    // Архивация/разархивация
    // Post /trees/archiveTree
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "archiveTree") {

        archiveTree($formData['tree_id'], $formData['archive']);
        echo json_encode(["success" => true]);
        return;
    }
    

    // перемещение дерева
    // Post /trees/moveTree
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "moveTree") {
        moveTree($formData['tree_id'], $formData['latitude'], $formData['longitude']);
        echo json_encode([
            "success" => true
        ]);
        return;
    }

    // изменение картинки дерева 
    // Post /trees/changeImageOfTree
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "changeImageOfTree") {
        $json = file_get_contents($_FILES['jsonbody']["tmp_name"]);
        writeToServerLog($json);
        $decoded_json = json_decode($json, true); /* сами данные */
        $file = $_FILES['treeImage'];
        $treeImage = uploadTreeImage($file, $decoded_json); /* получаем адрес до изображения, примерно uploads/1-1.png*/
        // $leafImage = uploadLeafImage();
        $result = changeImageOfTree($decoded_json['tree_id'], $treeImage); /* что-то еще с фото придумать */
        echo json_encode([
            "success" => true,
            "filename" => $treeImage
        ]);
        return;
    }
    
    // другие изменения
    // Post /trees/editTree
    if ($method == "POST" && count($urlData) === 1 && $urlData[0] === "editTree") {
        editTree($formData);
        // echo $sql;
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