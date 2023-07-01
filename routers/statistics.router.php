<?php 
/* new file  
роутер для всех запросов по площадкам
*/

function route($method, $urlData, $formData) {
    header('Content-Type: application/json');

    
    // возраст всех площадок
    // Get /statistics/age
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "age") {
        $result = getYearsOfTrees();
        foreach ($result as $item) {
            $item['age'] = date("Y") - $item['year'];
        }
        echo json_encode($result);
        return;
    }

    
    // возраст 1 площадки
    // Get /statistics/age/{location_id}
    if ($method == "GET" && count($urlData) === 2 && $urlData[0] === "age") {
        $result = getYearsOfTreesOfLocation($urlData[1]);
        foreach ($result as $item) {
            $item['age'] = date("Y") - $item['year'];
        }
        echo json_encode($result);
        return;
    }
    
    // породы всех площадок
    // Get /statistics/species
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "species") {
        $result = getSpecies();
        echo json_encode($result);
        return;
    }

    
    // породы 1 площадки
    // Get /statistics/species/{location_id}
    if ($method == "GET" && count($urlData) === 2 && $urlData[0] === "species") {
        $result = getSpeciesOfTreesOfLocation($urlData[1]);
        echo json_encode($result);
        return;
    }

    
    // количество опиливаний всех площадок
    // Get /statistics/cutCount
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "cutCount") {
        $result = getCutCount();
        echo json_encode($result);
        return;
    }

    
    // количество опиливаний 1 площадки
    // Get /statistics/cutCount/{location_id}
    if ($method == "GET" && count($urlData) === 2 && $urlData[0] === "cutCount") {
        $result = getcutCountOfLocation($urlData[1]);
        echo json_encode($result);
        return;
    }

    
    // количество опиливаний по площадкам
    // Get /statistics/cutCountLocs
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "cutCountLocs") {
        $result = getCutCountWithLocations();
        echo json_encode($result);
        return;
    }

    
    // причины опиливаний 
    // Get /statistics/cutReasons
    if ($method == "GET" && count($urlData) === 1 && $urlData[0] === "cutReasons") {
        $result = getCutReasons();
        echo json_encode($result);
        return;
    }

    // причины опиливаний на площадке
    // Get /statistics/cutReasons/{location_id}
    if ($method == "GET" && count($urlData) === 2 && $urlData[0] === "cutReasons") {
        $result = getCutReasonsOfLocation($urlData[1]);
        echo json_encode($result);
        return;
    }



    

    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
?>