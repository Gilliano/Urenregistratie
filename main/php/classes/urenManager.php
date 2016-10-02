<?php

class urenManager
{
    // TODO: Remove? (because old 'overzicht' layout has changed)
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

    // Returns uur record(s)
    // where idMedewerker = $userID
    // and idProject = $projectID
    // and begintijd is between $date1 and $date2
    // NOTE: date format is string('YYYY-MM-DD HH:MM:SS')
    public static function getRecordsForUserProjectDaterange($userID, $projectID, $date1, $date2)
    {
        error_log("$userID, $projectID, $date1, $date2");

        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT idUur, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, timestamp, goedgekeurd FROM uur WHERE idMedewerker = ? AND idProject = ? AND begintijd BETWEEN ? AND ? ORDER BY begintijd DESC;");
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->bindParam(2, $projectID, PDO::PARAM_INT);
        $stmt->bindParam(3, $date1, PDO::PARAM_STR);
        $stmt->bindParam(4, $date2, PDO::PARAM_STR);
        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    }
    
    static function addUren() {
        $conn = database::connect();
        // TODO: Rebuild this with ajax?
        $medewerker = $_SESSION['idMedewerker'];
        $project = $_POST['project'];
        $urenregulier = $_POST['urenregulier'];
        $ureninnovatief = $_POST['ureninnovatief'];
        $begintijd = $_POST['begintijd'];
        $eindtijd = $_POST['eindtijd'];
        $omschrijving = $_POST['omschrijving'];
        
        if($ureninnovatief <= 0) {
            $innovatief = FALSE;
                   
            $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, timestamp, goedgekeurd) VALUES ($medewerker, $project, $urenregulier, TIME '$begintijd', TIME '$eindtijd', '$omschrijving', FALSE, CURRENT_TIMESTAMP, FALSE)");
            
            if($stmt->execute() === TRUE) {
                return "<div class='alert alert-success' id='error'>De uren zijn succesvol geregistreerd</div>";
            }
            else {
                return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
            }
        }
        else {
            $innovatief = TRUE;
            
            $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, timestamp, goedgekeurd) VALUES ($medewerker, $project, $urenregulier, TIME '$begintijd', TIME '$eindtijd', '$omschrijving', FALSE, CURRENT_TIMESTAMP, FALSE)");
            
            if($stmt->execute() === TRUE) {
                $query = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, timestamp, goedgekeurd) VALUES ($medewerker, $project, $ureninnovatief, TIME '$begintijd', TIME '$eindtijd', '$omschrijving', $innovatief, CURRENT_TIMESTAMP, FALSE)");
                
                if($query->execute() === TRUE) {
                    return "<div class='alert alert-success' id='error'>De uren zijn succesvol geregistreerd</div>";
                }
                else {
                    return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
                }
            }
            else {
                return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
            }
        } 
    }
}

?>