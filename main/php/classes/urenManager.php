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
    
    static function addUren() {
        $conn = database::connect();
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