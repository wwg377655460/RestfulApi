<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/20
 * Time: 下午1:30
 */

class HttpUtils{
    public static function parseJson(){
        $json = @file_get_contents('php://input');
        return json_decode($json);
    }

    public static function validation($arr, $keys){
        foreach($keys as $key){
            if(!array_key_exists($key, $arr)){
                return false;
            }
        }

        return true;
    }

    public static function create_uuid($prefix = ""){    //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }


}