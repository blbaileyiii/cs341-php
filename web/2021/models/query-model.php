<?php
/*
 * HHSCAMPS JSON Model
 */

function getParticipantById($id) {
    try {
        $db = hhConnect();

        $sql = 
        'SELECT *
        FROM hhstake.registrants AS p
        WHERE p.id = :id
        ORDER BY p.id';

        $sqlVarArray = array(
            ':id' => $id
        );

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->fetchAll();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        echo $sql . "<br>" . $ex->getMessage();
    }
}

function getParticipantsByIds($ids) {
    $len = count($ids);

    $idArr = array();
    for($i = 0; $i < $len; $i++){
        $idArr[] = ":id$i";
    }

    try {
        $db = hhConnect();

        $sql = 
        'SELECT p.id,p.event_id
        FROM hhstake.registrants AS p
        WHERE p.id IN ('.implode(',', $idArr) .')
        ORDER BY p.id';

        $sqlVarArray = array();
        for($i = 0; $i < $len; $i++){
            $sqlVarArray[":id$i"] = $ids[$i];
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->fetchAll();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        //var_dump($ids);
        echo "<br>" . $sql . "<br>" . $ex->getMessage();
    }
}

function getEventsJSON($eventYear) {
    try {
        $db = hhConnect();

        $sql = 
        'SELECT *
        FROM hhstake.events AS e
        WHERE EXTRACT(YEAR FROM e.date_start) = :eventYear
        ORDER BY e.id';

        $sqlVarArray = array(':eventYear' => $eventYear);

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->fetchAll();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        echo $sql . "<br>" . $ex->getMessage();
    }
}

function getEquipmentJSON($reg_id) {
    try {
        $db = hhConnect();

        $sql = 
        'SELECT e.category, i.owned, e.id, e.quantity, e.name, e.avg_price, i.pur_price 
        FROM hhstake.equipment AS e
        LEFT JOIN hhstake.inventory AS i ON e.id = i.item_id AND i.reg_id = :reg_id
        ORDER BY e.category, e.name';
        /*
        'SELECT *
        FROM hhstake.equipment AS e
        ORDER BY e.category, e.name';
        */

        $sqlVarArray = array(
            ':reg_id' => $reg_id
        );

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->fetchAll();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        echo $sql . "<br>" . $ex->getMessage();
    }
}

function getInventoryByPId($reg_id) {
    try {
        $db = hhConnect();

        $sql = 
        'SELECT *
        FROM hhstake.inventory AS i
        WHERE i.reg_id = :reg_id
        ORDER BY i.reg_id';

        $sqlVarArray = array(
            ':reg_id' => $reg_id
        );

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->fetchAll();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        echo $sql . "<br>" . $ex->getMessage();
    }
}

function postItemJSON($reg_id, $item_id, $owned, $pur_price) {
    try {
        $db = hhConnect();

        $sql = 
        'INSERT INTO hhstake.inventory (reg_id, item_id, owned, pur_price)
        VALUES (:reg_id, :item_id, :owned, :pur_price)
        ON CONFLICT ON CONSTRAINT uq_reg_id_item_id
        DO UPDATE
        SET reg_id = :reg_id,
            item_id = :item_id,
            owned = :owned,
            pur_price = :pur_price';
        
        $sqlVarArray = array(
            ':reg_id' => $reg_id,
            ':item_id' => $item_id,
            ':owned' => $owned,
            ':pur_price' => $pur_price
        );

        $stmt = $db->prepare($sql);
        $stmt->execute($sqlVarArray);
        $returnSQL = $stmt->rowCount();
        $returnSQL = json_encode($returnSQL);

        // The next line closes the interaction with the database 
        $stmt->closeCursor();

        return $returnSQL;

    } catch(PDOException $ex) {
        echo $sql . "<br>" . $ex->getMessage();
    }
}

/* NOTES:
INSERT INTO the_table (id, column_1, column_2) 
VALUES (1, 'A', 'X'), (2, 'B', 'Y'), (3, 'C', 'Z')
ON CONFLICT (id) DO UPDATE 
  SET column_1 = excluded.column_1, 
      column_2 = excluded.column_2;
*/

?>