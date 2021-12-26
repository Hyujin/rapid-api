<?php
// Load the database configuration file
include_once 'db_conn.php';

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $answer_time                = $line[0];
                $talk_time                  = $line[1];
                $cx_phone                   = $line[2];
                $call_date_rcvd             = $line[3];
                $agent_name                 = $line[4];
                $acct_id                    = $line[5];

                $call_date_unformatted = date_create($call_date_rcvd);
                $call_date = date_format($call_date_unformatted, "Y-m-d H:i:s");


                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT id FROM calls_temp WHERE id = '".$line[4]."'";
                $prevResult = $db->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE calls_temp SET answer_time = '".$answer_time."', talk_time = '".$talk_time."', cx_phone = '".$cx_phone."', call_date = '".$call_date."', agent_name = '".$agent_name."' , acct_id = '".$acct_id."' ");
                }else{
                    // Insert member data in the database
                    $db->query("INSERT INTO calls_temp (answer_time, talk_time, cx_phone, call_date, agent_name, acct_id) VALUES ('".$answer_time."', '".$talk_time."', '".$cx_phone."', '".$call_date."','".$agent_name."', '".$acct_id."') ");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: index.php".$qstring);