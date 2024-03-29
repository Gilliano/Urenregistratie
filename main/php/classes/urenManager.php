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
    public static function getRecordsForUserProjectDaterange($userIDs, $projectIDs, $date1, $date2)
    {
        $records = [];
        $conn = database::connect();

        $query = "SELECT CONCAT(medewerker.voornaam,' ',COALESCE(medewerker.tussenvoegsels,''),' ',medewerker.achternaam) as 'medewerkerNaam', ";
        $query .= "project.projectnaam as 'projectNaam', uur.* ";
        $query .= "FROM uur INNER JOIN medewerker ON uur.idMedewerker=medewerker.idMedewerker ";
        $query .= "INNER JOIN project ON uur.idProject=project.idProject WHERE ";
        $index = 0;
        $values = [];
        foreach($userIDs as $userID)
        {
            $query .= $index == 0 ? "(" : "";
            $query .= "uur.idMedewerker = ?";
            $query .= $index == count($userIDs)-1 ? ") AND " : " OR ";
            $index++;
            array_push($values, $userID);
        }
        $index = 0;
        foreach($projectIDs as $projectID)
        {
            $query .= $index == 0 ? "(" : "";
            $query .= "uur.idProject = ?";
            $query .= $index == count($projectIDs)-1 ? ") AND " : " OR ";
            $index++;
            array_push($values, $projectID);
        }
        $query .= "(begintijd BETWEEN ? AND ?) ORDER BY begintijd ASC";

        $stmt = $conn->prepare($query);

        for($i = 1; $i <= count($values); $i++)
            $stmt->bindParam($i, $values[$i-1], PDO::PARAM_INT);
        $stmt->bindParam(count($values) + 1, $date1, PDO::PARAM_STR);
        $stmt->bindParam(count($values) + 2, $date2, PDO::PARAM_STR);

        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    }
    
static function addUren() {

    //Check if input fields are filled
    if (isset($_POST['begintijd'], $_POST['urenregulier'], $_POST['project'], $_POST['eindtijd'], $_POST['omschrijving'])) {

        $conn = database::connect();
        $medewerker = $_SESSION['idMedewerker'];
        $project = $_POST['project'];
        $urenregulier = $_POST['urenregulier'];
        $datum = $_POST['datum'];
        $Btijd = $datum . " " . $_POST['begintijd'];
        $date = date_create("$Btijd");
        $begintijd = date_format($date, "Y-m-d H:i:s");
        $Etijd = $datum . " " . $_POST['eindtijd'];
        $dag = date_create("$Etijd");
        $eindtijd = date_format($dag, "Y-m-d H:i:s");
        $omschrijving = $_POST['omschrijving'];
        $ureninnovatief = $_POST['ureninnovatief'];
        $goedgekeurd = FALSE;

        if ($ureninnovatief <= 0) {
            $innovatief = FALSE;

            $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $medewerker, PDO::PARAM_INT);
            $stmt->bindParam(2, $project, PDO::PARAM_INT);
            $stmt->bindParam(3, $urenregulier, PDO::PARAM_INT);
            $stmt->bindParam(4, $begintijd, PDO::PARAM_STR);
            $stmt->bindParam(5, $eindtijd, PDO::PARAM_STR);
            $stmt->bindParam(6, $omschrijving, PDO::PARAM_STR);
            $stmt->bindParam(7, $innovatief, PDO::PARAM_BOOL);
            $stmt->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

            if ($stmt->execute() === TRUE) {
                return "<div class='alert alert-success' id='error'>De uren zijn succesvol geregistreerd</div>";
            } else {
                return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
            }
        } else {
            $innovatief = TRUE;
            $inno = FALSE;

            $stmt = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $medewerker, PDO::PARAM_INT);
            $stmt->bindParam(2, $project, PDO::PARAM_INT);
            $stmt->bindParam(3, $urenregulier, PDO::PARAM_INT);
            $stmt->bindParam(4, $begintijd, PDO::PARAM_STR);
            $stmt->bindParam(5, $eindtijd, PDO::PARAM_STR);
            $stmt->bindParam(6, $omschrijving, PDO::PARAM_STR);
            $stmt->bindParam(7, $inno, PDO::PARAM_BOOL);
            $stmt->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

            if ($stmt->execute() === TRUE) {
                $query = $conn->prepare("INSERT INTO uur (idMedewerker, idProject, urengewerkt, begintijd, eindtijd, omschrijving, innovatief, goedgekeurd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $query->bindParam(1, $medewerker, PDO::PARAM_INT);
                $query->bindParam(2, $project, PDO::PARAM_INT);
                $query->bindParam(3, $ureninnovatief, PDO::PARAM_INT);
                $query->bindParam(4, $begintijd, PDO::PARAM_STR);
                $query->bindParam(5, $eindtijd, PDO::PARAM_STR);
                $query->bindParam(6, $omschrijving, PDO::PARAM_STR);
                $query->bindParam(7, $innovatief, PDO::PARAM_BOOL);
                $query->bindParam(8, $goedgekeurd, PDO::PARAM_BOOL);

                if ($query->execute() === TRUE) {
                    return "<div class='alert alert-success' id='error'>De uren zijn succesvol geregistreerd</div>";
                } else {
                    return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
                }
            } else {
                return "<div class='alert alert-danger' id='error'>De uren konden niet geregistreerd worden.</div>";
            }
        }
    }
    else {
            return "<div class='alert alert-danger' id='error'>Vul alle invoervelden in!</div>";
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