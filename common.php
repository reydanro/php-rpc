<?php 

    ////////////////////////////////////////////////////////////////////////////
    
    function reterr($code, $msg = null)
    {
        return array("error" => array("code" => $code, "message" => $msg));
    }

    
    function get_random_string($valid_chars, $length)
    {
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
    
        for ($i = 0; $i < $length; $i++)
        {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $random_string .= $random_char;
        }

        return $random_string;
    }    
    
    function safeimagecreatefrompng($url)
    {
        if (file_exists($url))
            return imagecreatefrompng($url);
        else
            return null;
    }
    
    function safeimagecreatefromjpeg($url)
    {
        if (file_exists($url))
            return imagecreatefromjpeg($url);
        else
            return null;
    } 
    
    function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) 
            return true;
    
        return (substr($haystack, -$length) === $needle);
    }
    
    function selfurl() 
    {
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s": "";
        $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
    }
       
    function strleft($s1,$s2) 
    {
        return substr($s1, 0, strpos($s1, $s2));
    }   
        
    function safeescape($obj)
    {
        if ($obj == null)
            return null;
            
        if (is_array($obj))
        {
            $ret = array();
            foreach ($obj as $k => $v)
                $ret[$k] = db()->escape_string($v);
            return $ret;
        }
        else
            return db()->escape_string($obj);
    }
	 
?>