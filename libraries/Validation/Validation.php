<?php

class Validation {

    

    public function isUrl($str){

        if(filter_var($str, FILTER_VALIDATE_URL)===false){

            return false;

        }

        return true;

    }

    

    public function isEmail($str){

        if(filter_var($str, FILTER_VALIDATE_EMAIL)===false){

            return false;

        }

        return true;

    }

    

    public function isBool($str){

        $str = strtolower($str);

        return (in_array($str, array("true", "false", "1", "0", "yes", "no"), true));

    }

    

    public function isAlpha($str){

        return ctype_alpha($str);

    }

    

    public function isAlphaNum($str){

        return ctype_alnum($str);

    }

    

    public function isNum($str){

        return ctype_digit($str);

    }

    

    

    

    

}

?>