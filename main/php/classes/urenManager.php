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
        
        //Check if input fields are filled
        if(isset($_POST['project']) && isset($_POST['urenregulier']) && isset($_POST['ureninnovatief']) && isset($_POST['datum']) && isset($_POST['begintijd']) && isset($_POST['eindtijd']) && isset($_POST['omschrijving'])) {
            
            $conn = database::connect();
            $medewerker = $_SESSION['idMedewerker'];
            $project = $_POST['project'];
            $urenregulier = $_POST['urenregulier'];
            $ureninnovatief = $_POST['ureninnovatief'];
            $datum = $_POST['datum'];
            $Btijd = $datum . " " . $_POST['begintijd'];
            $date = date_create("$Btijd");
            $begintijd = date_format($date,"Y-m-d H:i:s");
            $Etijd = $datum . " " . $_POST['eindtijd'];
            $dag = date_create("$Etijd");
            $eindtijd = date_format($dag,"Y-m-d H:i:s");
            $omschrijving = $_POST['omschrijving'];
            $goedgekeurd = FALSE;

            if($ureninnovatief <= 0) {
                $innovatief = FALSE;

                $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief,  goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $medewerker, PDO::PARAM_INT);
                $stmt->bindParam(2, $project, PDO::PARAM_INT);
                $stmt->bindParam(3, $urenregulier, PDO::PARAM_INT);
                $stmt->bindParam(4, $begintijd, PDO::PARAM_STR);
                $stmt->bindParam(5, $eindtijd, PDO::PARAM_STR);
                $stmt->bindParam(6, $omschrijving, PDO::PARAM_STR);
                $stmt->bindParam(7, $innovatief, PDO::PARAM_BOOL);
                $stmt->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

                if($stmt->execute() === TRUE) {
                    return "<div class='alert alert-success' id='error'>De uren zijn succesvol geregistreerd</div>";
                }
                else {
                    return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
                }
            }
            else {
                $uren = FALSE;
                $innovatief = TRUE;

                $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief,  goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $medewerker, PDO::PARAM_INT);
                $stmt->bindParam(2, $project, PDO::PARAM_INT);
                $stmt->bindParam(3, $urenregulier, PDO::PARAM_INT);
                $stmt->bindParam(4, $begintijd, PDO::PARAM_STR);
                $stmt->bindParam(5, $eindtijd, PDO::PARAM_STR);
                $stmt->bindParam(6, $omschrijving, PDO::PARAM_STR);
                $stmt->bindParam(7, $uren, PDO::PARAM_BOOL);
                $stmt->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

                if($stmt->execute() === TRUE) {
                    $query = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $query->bindParam(1, $medewerker, PDO::PARAM_INT);
                    $query->bindParam(2, $project, PDO::PARAM_INT);
                    $query->bindParam(3, $urenregulier, PDO::PARAM_INT);
                    $query->bindParam(4, $begintijd, PDO::PARAM_STR);
                    $query->bindParam(5, $eindtijd, PDO::PARAM_STR);
                    $query->bindParam(6, $omschrijving, PDO::PARAM_STR);
                    $query->bindParam(7, $innovatief, PDO::PARAM_BOOL);
                    $query->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

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
        else {
            return "<div class='alert alert-danger' id='error'>Vul alle invoervelden in!</div>";
        }
}
}
?>