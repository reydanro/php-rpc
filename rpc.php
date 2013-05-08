<?php
    
    // First include the core file
    include ('rpc.core.php');
    include ('common.php');

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    // Include all other rpc files
    foreach (GetFilesWithRegex(null, "/^rpc\.(.*).php/") as $inc)
    {
        if (strcmp($inc, "rpc.core.php") == 0)
            continue;
        include ($inc);
    }
    
    ////////////////////////////////////////////////////////////////////////////
    // Include all user methods
    include("func.php");
    foreach (GetFilesWithRegex(null, "/^func\.(.*).php/") as $inc)
        include ($inc);


    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    // Always fix any attached files
    $_FIXED_FILES = FixGlobalFilesArray($_FILES);

    ////////////////////////////////////////////////////////////////////////////
    // Fast get of some request parameters
    $signature = safeget($_REQUEST, "signature", null, false);

    $func = safeget($_REQUEST, "func", null, false);
    
    $param = safeget($_REQUEST, "param", null, false);
    if ($param != null)
    {
        // Make sure we don't have escaped quotes
        if (get_magic_quotes_gpc())
            $param = stripslashes($param);
    }

    ////////////////////////////////////////////////////////////////////////////
    // Now, check if the call is correctly signed.
    // Compare our own computed signature with the received signature
    $REQUEST_IS_SIGNED = strcmp(md5($SIGNATURE_SECRET.$func.$param), $signature) == 0;        
    
    ////////////////////////////////////////////////////////////////////////////
    // Log the call
    $now = date("Y-m-d H:i:s");
    
    $logline = "[$now][".basename(__FILE__)."] Signed=".$REQUEST_IS_SIGNED." Func=".safeget($_REQUEST, "func", null, false)."   Param=".safeget($_REQUEST, "param", null, false);
    $logline .= "\r\n";
    $logname = "calllog_".date("Y-m-d").".txt";
    file_put_contents($logname, $logline, FILE_APPEND);
    
    ////////////////////////////////////////////////////////////////////////////
    // Test the method name
    if ($func === null)
    {
        echo "No function name found!";
        exit();
    } 

    ////////////////////////////////////////////////////////////////////////////
    // Optionally, get the param
    if ($param != null)
    {
        // If we have a param, then try to convert it from json    
        $decode = json_decode($param, true);
        if ($decode != NULL)
            $param = $decode;
    }
    
    ////////////////////////////////////////////////////////////////////////////
    // Call the method
    ////////////////////////////////////////////////////////////////////////////

    // This variable is free to be overwritten by methods, which will handle output themselves
    $_CONTENTTYPE = "application/json";
    
    // Make the method call
    if (function_exists($func)) 
        $ret = call_user_func($func, $param);
    else
    {
        echo "Missing function: $func";
        exit(1);
    }

    // If the method returns null, do not output anything else (output is controlled from the function)
    if ($ret !== null)
    {
        if ($_CONTENTTYPE == "application/json")
        {
            header ("Content-Type: $_CONTENTTYPE");
            echo json_encode($ret);
        }
    }


    // Close the database
    dbclose();

?>