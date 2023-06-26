<?php
// Универсальный метод получения справочных данных
function getSpecies() {
    $stmt = Connection::get()->query('SELECT * FROM `species` order by name;');
    $result = [];
    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $result[$i] = $row;
        }
    }
    return $result;
}

function editSpecies($data) {
    $sql = "UPDATE `species` SET name = '".$data['name']."' WHERE id = ".$data['id'];
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
    return true;
}

function addSpecies($data) {
    $sql = "INSERT INTO `species` (`name`) VALUES('".$data['name']."')";
    writeToServerLog($sql);
    $stmt = Connection::get()->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        var_dump($row);
    }
}
