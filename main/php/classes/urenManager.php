<?php

class urenManager
{
    // Returns all records from table `uur`
    public static function getAllRecords($pageNumber)
    {
        $records = [];
        $resultPerPage = 10; // Max results you will see per page
        $startLimit = intval(($pageNumber * $resultPerPage) - $resultPerPage); // Where the limit starts
        
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM uur LIMIT ?, 10");
        $stmt->bindParam(1, $startLimit, PDO::PARAM_INT);
        $stmt->execute();
        
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($records, $record);
        }
        
        return $records;
    }
}

?>