<?php

class Logs
{

    public static function wr($str){


        $str = Date::getCreateTime()." : ".str_replace("<br/>"," ",$str)." ".$_SERVER["REQUEST_URI"];

        $fileLog = fopen(LOGS_PATH."log.txt", "a");

        fwrite($fileLog, $str."\r\n");

        fclose($fileLog);

    }

}

