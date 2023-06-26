<?php 
/* new file ! 
    здесь запросы, связанные с площадками - добавление, изменение, список 
*/

// Получить список площадок
function getLocations() {
    $stmt = Connection::get()->query('select * from locations');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

// Добавить площадку
function addLocation($data, $img) {
    $sql = "INSERT INTO `locations`(`name`, `latitude_center`, `longitude_center`, `photo`) VALUES ('".$data['name']."',".$data['latitude_center'].",".$data['longitude_center'].",'".$img."');";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Перемещение площадки (изменение координат)
function moveLocation($location_id, $lat, $long) {
    $sql = "UPDATE `locations` SET `latitude_center`= ".$lat.",`longitude_center`=".$long." WHERE id = ".$location_id;

    // return $sql;
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// Изменение картинки площадки 
function changeImageOfLocation($location_id, $img) {
    $sql = "UPDATE `locations` SET `photo`='".$img."' WHERE id = ".$location_id;
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}

// редактирование площадки в целом 
function editLocation($data) {
    $sql = "UPDATE `locations` SET `name`='".$data['name']."',`latitude_center`=".$data['latitude'].",`longitude_center`=".$data['longitude']." WHERE id = ".$data['location_id'];
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
?>