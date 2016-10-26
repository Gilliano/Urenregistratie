<?php

class projectManager
{
    // Returns all names from `project` table
    public static function getAllProjects()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM project");
        $stmt->execute();
        $records = $stmt->fetchAll();
        
        return $records;
    }
    // Returns all names from 'project' that isn't deleted.
    public static function getAllCurrentProjects()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM project WHERE verwijderd = 0");
        $stmt->execute();
        $records = $stmt->fetchAll();

        return $records;
    }
    
    // Returns project name from table `project`
    // params: idProject
    public static function getProjectNameFromID($id)
    {
        $projectnaam = "";
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT projectnaam FROM project WHERE idProject = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $projectnaam = $stmt->fetch();
        
        return $projectnaam;
    }

    // Returns project name from table `project`
    // params: projectnaam
    public static function getProjectIDFromName($projectName)
    {
        $projectID = -1;
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT idProject FROM project WHERE projectnaam = ?");
        $stmt->bindParam(1, $projectName, PDO::PARAM_STR);
        $stmt->execute();
        $projectID = $stmt->fetch();

        return $projectID;
    }

    public static function toggleProjectFromID($projectId, $delete) {
        $conn = database::connect();

        if($delete == 0) {
            $deletetoggle = 1;
        } else {
            $deletetoggle = 0;
        }

        echo $deletetoggle;

        try {
            $updateUser = " UPDATE project
                                SET
                                verwijderd=?
                                WHERE idProject=?";
            $stmt       = $conn->prepare($updateUser);
            $stmt->bindParam(1, $deletetoggle);
            $stmt->bindParam(2, $projectId);
            $stmt->execute();

            header('Location: ../?page=projecten');
            return NULL;
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    // TODO: Function to get all projects that match userID
}

?>