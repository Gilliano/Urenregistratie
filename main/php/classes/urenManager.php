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

    // Updates the record in `uur` tabel
    // foreach element in param array
    // parameters: Array which contains
    // all the changed records (as an
    // associative array that reflects the
    // `uur` tabel columns=>values)
    public static function UpdateUren($records_array)
    {
        $conn = database::connect();
        $stmts = [];
        foreach($records_array as $record)
        {
            // Create the query as string
            $query = "UPDATE uur SET ";
            $values = [];
            $index = 1; // Index is used for tracking the position in the $record array
            foreach ($record as $key => $value)
            {
                $query .= $key." = ?"; // Add "Keyname = ?" to the query string
                $query .= $index == count($record) ? " WHERE idUur = ?;" : ", "; // Decide what to do when we reach the end
                array_push($values, $value); // Put the values for the keys in the list
                $index++; // Increase the index
            }

            // Create the statement with the query string
            $stmt = $conn->prepare($query);

            // Bind all params to the statement
            for($i = 1; $i <= count($values); $i++)
                $stmt->bindParam($i, $values[$i-1]);
            $stmt->bindParam(count($values) + 1, $record["idUur"], PDO::PARAM_INT); // Set WHERE idUur value

            // Put the statement in the list
            array_push($stmts, $stmt);
        }

        $results = [];
        foreach ($stmts as $stmt)
            array_push($results, $stmt->execute() ? "Succes" : "Failed"); // Add the execute() results to the list

        return $results;
    }
}

?>