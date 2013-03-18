<?php
    function GetFilesWithRegex($folder, $regex)
    {
        $ret = array();
        
        if ($folder == null)
            $folder = ".";
        
        if ($handle = opendir($folder)) 
        {
            while (($filename = readdir($handle)) !== false) 
            {
                if (preg_match($regex, $filename))
                    $ret[] = $filename;
                
            }
            closedir($handle);
        }
        
        return $ret;
    }


    ////////////////////////////////////////////////////////////////////////////
    
    function FixGlobalFilesArray($files) 
    {
        $ret = array();
        
        if(isset($files['tmp_name']))
        {
            if (is_array($files['tmp_name']))
            {
                foreach($files['name'] as $idx => $name)
                {
                    $ret[$idx] = array(
                        'name' => $name,
                        'tmp_name' => $files['tmp_name'][$idx],
                        'size' => $files['size'][$idx],
                        'type' => $files['type'][$idx],
                        'error' => $files['error'][$idx]
                    );
                }
            }
            else
            {
                $ret = $files;
            }
        }
        else
        {
            foreach ($files as $key => $value)
            {
                $ret[$key] = fixGlobalFilesArray($value);
            }
        }
        
        return $ret;
    }
    
    ////////////////////////////////////////////////////////////////////////////
    
    function safeget($array, $key, $default = null, $esc = true)
    {
        if ($array === NULL)
            return $default;
            
        if (is_array($array) && array_key_exists($key, $array))
        {
            $val = $array[$key];
        }
        else
            $val = $default;
            
        //echo "Value:$val\n";
        if ($esc == true)
            $val = safeescape($val);
            
        return $val;           
    }    

?>