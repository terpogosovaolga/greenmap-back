<?php 
/* new file ! 
    здесь запросы, связанные с деревьями - добавление, изменение, список 
*/

// Получить список деревьев по площадке
function getTreesInLocation($location_id) {
    $sql = "SELECT t.`id`, `id_location` AS 'location', t.`name`, `tree_number`, `id_species` AS 'species', `latitude`, `longitude`, `height`, `tdiameter`, `cdiameter`, `dry`, `detachment`, `cracks`, `drips`, `tilt`, `overhanging_t`, `overhanging_p`, `overhanging_comments`, `overhanging_d`, `archive`, t.`photo`, a.name as 'name_location', s.name as 'name_species' FROM `trees` AS t JOIN locations AS a ON id_location = a.id JOIN species AS s ON id_species = s.id WHERE archive = 0 AND id_location = " . $location_id;
    $stmt = Connection::get()->query($sql);

    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}


// Добавить дерево
function addTree($data, $img) {
    $sql_new = "INSERT INTO `trees` (`id_location`, `tree_number`, `id_species`, `name`, `latitude`, `longitude`, `height`, `year`, `tdiameter`, `cdiameter`, `dry`, `detachment`, `cracks`, `drips`, `tilt`, `overhanging_t`, `overhanging_p`, `overhanging_d`, `photo`) VALUES (".$data['location'].", 1, ".$data['species'].", '".$data['name']."', ".$data['coordinates'][0].", ".$data['coordinates'][1].", ".$data['height'].", ".$data['year'].", ".$data['tdiameter'].", ".$data['cdiameter'].", ".$data['dry'].", ".$data['detachment'].", ".$data['cracks'].", ".$data['drips'].", ".$data['tilt'].", ".$data['overhanging_t'].", ".$data['overhanging_p'].", ".$data['overhanging_d'].", '".$img."');";
    writeToServerLog($sql_new);
    $stmt = Connection::get()->query($sql_new);
    if (!is_null($data['overhanging_comments'])) {
        $sql2 = "SELECT `id` FROM `trees` ORDER BY `id` DESC LIMIT 1";
        $stmt2 = Connection::get()->query($sql2);
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
            $id = $row['id'];
        }
        $tree = getTreeById($id);
        $sql2 = "UPDATE `trees` SET `overhanging_comments` = '".$data['overhanging_comments']."' WHERE `id` = ".$id;
        $stmt3 = Connection::get()->query($sql2);
        var_dump($stmt3);
    }

    return $stmt;
}

// Фильтрация
function filterTrees($data) {

}

// Архивация
function archiveTree($tree_id, $archive) {
    $sql = "UPDATE trees SET `archive`=".$archive." WHERE id = ".$tree_id;
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// перемещение дерева
function moveTree($tree_id, $lat, $long) {
    $sql = "UPDATE trees SET `latitude`=".$lat.", `longitude`=".$long." WHERE id = ".$tree_id;
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}


// Изменение картинки дерева 
function changeImageOfTree($tree_id, $img) {
    $sql = "UPDATE `trees` SET `photo`='".$img."' WHERE id = ".$tree_id;
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// другие изменения
function editTree($data) {
    $sql = "UPDATE `trees` SET `id_species`=".$data['species'].", `name` = '".$data['name']."', `latitude`=".$data['coordinates'][0].",`longitude`=".$data['coordinates'][1].",`height`=".$data['height'].",`year`=".$data['year'].",`tdiameter`=".$data['tdiameter'].",`cdiameter`=".$data['cdiameter'].",`dry`=".$data['dry'].",`detachment`=".$data['detachment'].",`cracks`=".$data['cracks'].",`drips`=".$data['drips'].",`tilt`=".$data['tilt'].",`overhanging_t`=".$data['overhanging_t'].",`overhanging_p`=".$data['overhanging_p'].",`overhanging_d`=".$data['overhanging_d']." WHERE id=".$data['tree_id'];
    writeToServerLog($sql);
    // return $sql;
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
    if (isset($data['overhanging_comments']) && !is_null($data['overhanging_comments'])) {
        $sql = "UPDATE `trees` SET `overhanging_comments`='".$data['overhanging_comments']."' WHERE id=".$data['tree_id'];
    }
    else if (is_null($data['overhanging_comments'])) {
        $sql = "UPDATE `trees` SET `overhanging_comments`= NULL WHERE id=".$data['tree_id'];
    }
    
    $stmt = Connection::get()->query($sql);
    // return $sql;
}

function getTreeById($id) {
    echo $id;
    $sql = "SELECT t.`id`, `id_location`, `tree_number`, `latitude`, `longitude`, `height`, `year`, `tdiameter`, `cdiameter`, `dry`, `detachment`, `cracks`, `drips`, `tilt`, `overhanging_t`, `overhanging_p`, `overhanging_comments`, `overhanging_d`, `archive`, t.`photo`, a.name as 'name_location', s.name as 'name_species' FROM `trees` AS t JOIN locations AS a ON id_location = a.id JOIN species AS s ON id_species = s.id WHERE t.id =" . $id;
    echo $sql;
    $stmt = Connection::get()->query($sql);

    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

function getSpeciesByName($name) {
    $stmt = Connection::get()->query('SELECT * FROM `species` WHERE name = "'.$name.'"');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

// function addGlossaryData($tableName, $data) {
//     $sql = "INSERT INTO `".$tableName."` (`name`) VALUES('".$data['name']."')";
//     writeToServerLog($sql);
//     $stmt = Connection::get()->query($sql);
//     while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         var_dump($row);
//     }
// }

function getYearsOfTrees() {
    $stmt = Connection::get()->query('SELECT count(id) as count, t.year, max(year(curdate()) - t.year) as `age` FROM `trees` as t group by t.year;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

function getYearsOfTreesOfLocation($location_id) {
    $stmt = Connection::get()->query('SELECT count(id) as count, t.year, max(year(curdate()) - t.year) as `age` FROM `trees` as t where id_location='.$location_id.' group by t.year;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}


// function getSpecies() {
//     $stmt = Connection::get()->query('SELECT count(t.id) as count, t.id_species as id_species, max(s.name) as species FROM `trees` as t JOIN `species` as s ON t.id_species = s.id group by t.id_species');
//     $result = [];
//     while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
//         for ($i = 0; $i < count($rows); $i++) {
//             $row = $rows[$i];
//             $result[$i] = $row;
//         }
//     }
//     return $result;
// }

function getSpeciesOfTreesOfLocation($location_id) {
    $stmt = Connection::get()->query('SELECT count(t.id) as count, t.id_species as id_species, max(s.name) as species FROM `trees` as t JOIN `species` as s ON t.id_species = s.id where id_location = '.$location_id.' group by t.id_species');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

function getCutCount() {
    $stmt = Connection::get()->query('SELECT count(t1.id) as `count_cut` FROM `trees` as t1 WHERE dry=1 OR detachment=1 OR cracks=1 OR drips=1 OR overhanging_t=1 OR overhanging_p=1 OR overhanging_d=1;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    $stmt2 = Connection::get()->query('SELECT count(t1.id) as `count_good` FROM `trees` as t1 WHERE dry=0 AND detachment=0 AND cracks=0 AND drips=0 AND overhanging_t=0 AND overhanging_p=0 AND overhanging_d=0;');
    $result2 = [];
    while($rows = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result2[$i] = $row;
        }
    }

    return [$result[0]['count_cut'],$result2[0]['count_good']];
}
function getCutCountOfLocation($location_id) {
    $stmt = Connection::get()->query('SELECT count(t1.id) as `count_cut` FROM `trees` as t1 WHERE (dry=1 OR detachment=1 OR cracks=1 OR drips=1 OR overhanging_t=1 OR overhanging_p=1 OR overhanging_d=1) AND id_location='.$location_id);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    $stmt2 = Connection::get()->query('SELECT count(t1.id) as `count_good` FROM `trees` as t1 WHERE dry=0 AND detachment=0 AND cracks=0 AND drips=0 AND overhanging_t=0 AND overhanging_p=0 AND overhanging_d=0 AND id_location='.$location_id);
    $result2 = [];
    while($rows = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result2[$i] = $row;
        }
    }

    return [$result[0]['count_cut'],$result2[0]['count_good']];
}

function getCutCountWithLocations() {
    $stmt = Connection::get()->query('SELECT count(t1.id) as `count_cut`, id_location as "location", l.name as "location_name" FROM `trees` as t1 JOIN locations as l ON t1.id_location = l.id WHERE dry=1 OR detachment=1 OR cracks=1 OR drips=1 OR overhanging_t=1 OR overhanging_p=1 OR overhanging_d=1 GROUP BY id_location;
    ');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }

    return $result;
}

function getCutReasons() {
    $array = [];

    $stmt = Connection::get()->query('select count(id) as count, "dry" as reason from trees where dry = 1');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }

    $stmt2 = Connection::get()->query('select count(id) as count, "detachment" as reason from trees where detachment = 1');
    $result2 = [];
    while($rows = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result2[$i] = $row;
        }
    }
    
    $stmt3 = Connection::get()->query('select count(id) as count, "cracks" as reason from trees where cracks = 1');
    $result3 = [];
    while($rows = $stmt3->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result3[$i] = $row;
        }
    }

    array_push($array, $result[0], $result2[0], $result3[0]);

    return $array;
}


function getCutReasonsOfLocation($location_id) {
    $array = [];

    $stmt = Connection::get()->query('select count(id) as count, "dry" as reason from trees where dry = 1 and id_location = '.$location_id);
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }

    $stmt2 = Connection::get()->query('select count(id) as count, "detachment" as reason from trees where detachment = 1 and id_location = '.$location_id);
    $result2 = [];
    while($rows = $stmt2->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result2[$i] = $row;
        }
    }
    
    $stmt3 = Connection::get()->query('select count(id) as count, "cracks" as reason from trees where cracks = 1 and id_location = '.$location_id);
    $result3 = [];
    while($rows = $stmt3->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result3[$i] = $row;
        }
    }

    array_push($array, $result[0], $result2[0], $result3[0]);

    return $array;
}
?>