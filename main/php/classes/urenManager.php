<?php

class urenManager
{
    // Returns all records from table `uur`
    function getAllRecords()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM uur");
        $stmt->execute();
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($records, $record);
        }
        
        return $records;
    }
}

?>