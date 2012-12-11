<?php
    function Test($param)
    {
        $ret = array();
             
        $ret["demo"] = "demo";
        $ret["paramreflection"] = $param;
             
        return $ret;
    }
    
    function TestDB()
    {       
        $ret = array();

        $query = "SELECT 1 AS demo";
        
        $result = dbexec($query);
        if (db()->affected_rows)
        {
            //$ret = $result->fetch_all(MYSQLI_ASSOC);
            while ($row = $result->fetch_assoc())
                $ret[] = $row;
        }
        
        return $ret;
    }

?>