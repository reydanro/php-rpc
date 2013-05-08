<?php

    ////////////////////////////////////////////////////////////////////////////

    $dbcon = null;

    function db()
    {
        global $dbcon;
        if ($dbcon == null)
            dbconnect();            
        return $dbcon;
    }

    ////////////////////////////////////////////////////////////////////////////

    function dbexec($query, $errorcheck = true)
    {
        global $dbcon;
        
        if ($dbcon == null)
            dbconnect();
        
        $result = $dbcon->query($query);        
        if ($errorcheck && $dbcon->errno != 0)
        {
            echo $dbcon->error;
            exit(1);
        }
        return $result;
    } 
    
    function dbconnect()
    {
        global $dbcon;
        global $DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME;
        
        //Connect to the database when someone tries to use this for the first time 
        if ($dbcon == null)
        {
            $dbcon = new mysqli($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
            if ($dbcon->connect_errno)
            { 
                echo "Failed to connect to DB";
                exit();
            }
            
            $dbcon->set_charset("utf8");
        }
    }
   
    function dbclose()
    {
        global $dbcon;
        
        if ($dbcon != null)
            $dbcon->close();    
    }   


?>