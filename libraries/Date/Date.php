<?php  
/**
 * Class Date - Time
 * @category Library
 * @package Date
 * @author LVP [levanphu.info] <vanphupc50@gmail.com>
 * @copyright 2018 LP Group
 * @version 1.0
 */

class Date
{
    public static function foldermtime($dir)
    {

        $foldermtime = 0;

        $flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_FILEINFO;

        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, $flags));

        while ($it->valid()) {

            if (($filemtime = $it->current()->getMTime()) > $foldermtime) {

                $foldermtime = $filemtime;

            }

            $it->next();

        }

        return $foldermtime ?: false;

    }



    public static function getCreateTime($format = "Y/m/d H:i:s")
    {

        $today = new DateTime();

        $create_time = $today->format($format);

        return $create_time;

    }



    public static function getWeekDayStr($date)
    {

        $date = new DateTime($date);

        $w = $date->format("w");

        switch($w){

            case "0":

                $w = "日";

                break;

            case "1":

                $w = "月";

                break;

            case "2":

                $w = "火";

                break;

            case "3":

                $w = "水";

                break;

            case "4":

                $w = "木";

                break;

            case "5":

                $w = "金";

                break;

            case "6":

                $w = "土";

                break;

            default :

                $w = "";

        }

        return $w;

    }



    public static function getWeekDayInt($date)
    {

        $date = new DateTime($date);

        $w = $date->format("w");

        return $w;

    }
}
?>