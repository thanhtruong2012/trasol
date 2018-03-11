<?php

class Lang{

    public static $lang;

    public static $lang_com;

    //public $

    function __construct(){

        

    }

    

    static function set($lb){

        echo isset(Lang::$lang[$lb])?Lang::$lang[$lb]:"";

    }

    

    static function set_com($lb){

        echo isset(Lang::$lang_com[$lb])?Lang::$lang_com[$lb]:"";

    }

}

?>