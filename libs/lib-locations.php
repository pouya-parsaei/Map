<?php
function insertLocation($data)
{
    global $pdo;
    //validation here ...
    $sql = "INSERT INTO `locations` ( `title`, `lat`, `lng`, `type`) VALUES ( :title, :lat, :lng, :typ);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':title' => $data['title'], ':lat' => $data['lat'], ':lng' => $data['lng'], ':typ' => $data['type']]);
    return $stmt->rowCount();
}

function getLocations($params = [])
{
    global $pdo;
    $conditions = '';
    if (isset($params['verified']) && in_array($params['verified'], ['0', '1'])) {
        $conditions = "WHERE verified = {$params['verified']}";
    } else if (isset($params['keyword'])) {
        $conditions = "WHERE verified = 1 AND title LIKE '%{$params['keyword']}%'";
    } else if (isset($params['coordinates'])) {
        $conditions = "WHERE lat BETWEEN {$params['coordinates']['south']} AND {$params['coordinates']['north']} AND lng BETWEEN {$params['coordinates']['west']} AND {$params['coordinates']['east']}";
    }
    $sql = "SELECT * FROM `locations` $conditions";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getLocation($id)
{
    global $pdo;
    $sql = "SELECT * FROM `locations` WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function toggleStatus($id)
{
    global $pdo;
    $sql = "UPDATE locations SET verified= 1 - verified WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
}
