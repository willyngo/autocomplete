<?php
require_once('dbUtility.php');

function getFromHistory($user){
    $pdo = getDbConnection();
    $query = "SELECT cityname FROM history WHERE username = ? ORDER BY searchDate DESC;";
    
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(1, $user);
    $list = array();
    if($stmt->execute()){
        while($row = $stmt->fetch()){
            array_push($list, $row);
        }
    }
    
    return $list;
}


function updateHistory($cityname, $user){
    $pdo = getDbConnection();
    $updateQuery = "UPDATE history SET searchDate = DEFAULT WHERE cityname = ? AND username = ?;";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(1, $cityname);
    $updateStmt->bindParam(2, $user);
            
    $updateStmt->execute();
}



/**
 * Determines whether or not the user already has the entry in his history.
 * @param type $cityname
 * @param type $user
 * @return boolean
 */
function historyAlreadyExists($cityname, $user){
    $pdo = getDbConnection();
    $query = "SELECT cityname FROM history WHERE cityname = ? AND username = ?;";
    $alreadyExists = false;
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $cityname);
    $stmt->bindParam(2, $user);
    
    if($stmt->execute()){
        if(($row = $stmt->fetch()) > 0){
            $alreadyExists = true;
        }
    }
    
    return $alreadyExists;
}


function setHistory($username){
    $myHistory = getFromHistory($username);    
    for($i = 0; $i < count($myHistory); $i++){
        echo "<p>{$myHistory[$i]['cityname']}</p>";
    }
}

function addToHistoryTable($user, $city) {
    try {
        $pdo = getDbConnection();
        if (historyAlreadyExists($city, $user)) {
            updateHistory($city, $user);
        } else {
            $query = "INSERT INTO history(username, cityname, searchDate, weight) VALUES (?, ?, ?, ?);";
            $searchDate = date('Y-m-d H:i:s');
            $weight = getWeightFromCity($city);
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(1, $user);
            $stmt->bindParam(2, $city);
            $stmt->bindParam(3, $searchDate);
            $stmt->bindParam(4, $weight);

            if ($stmt->execute()) {
                echo "SUCCESS!";
            }
        }
    } catch (PDOException $pdoe) {
        echo $pdoe->getMessage();
    }
}

function deleteHistory($user){
    $pdo = getDbConnection();
    $query = "DELETE FROM history WHERE username = ?";
    
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(1, $user);
    
    if($stmt->execute()){
        echo "Your user history has been deleted!";
    }
}