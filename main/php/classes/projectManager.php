<?php

class projectManager
{
    // Returns all names from `project` table
    public static function getAllProjectNames()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM project");
        $stmt->execute();
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($records, $record);
        }
        
        return $records;
    }
    public static function getAllCurrentProject()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT projectnaam FROM project WHERE verwijderd = 0");
        $stmt->execute();
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($records, $record['projectnaam']);
        }
        return $records;
    }
    
    // Returns project name from table `project`
    // params: idProject
    public static function getProjectNameFromID($id)
    {
        $projectnaam = "";
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT projectnaam FROM project WHERE idProject = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $projectnaam = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $projectnaam;
    }
}

?>