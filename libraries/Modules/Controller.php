<?php
/**
 * Class Controller
 * A library class for controller in MVC model. This contain method common
 * used for both Back-end and Front-end controller.
 * @category Library
 * @package Controller
 * @copyright 2016
 * @version 1.0
 * @since 1.0
 */
class Controller
{
    public $actFactory;
    function __construct(){
        $this->result = array("code"=>"","msg"=>"");
        $this->user = array(
            "agent_code" => "KIS"
        );
    }
    
    public function res($code,$data = array()){
        $msg = "";
        switch($code){
            case 1:
                $str = "Success";
                break;
            default:
                $str = "Error";
                 break;   
        }
        $res = array(
            "result" => array("code" => $code,"msg" => $str)
        );
        if(!empty($data)){
            $res["data"] = $data;
        }else{
            $res["data"] = array();
        }
        
        echo json_encode($res);
        die;
    }
    
    public function response($res){
        $code = isset($res['code'])?$res['code']:1;
        $msg = ErrorMsg::get_msg($code);
        $data = isset($res['data'])?$res['data']:false;
        if(isset($res['msg'])&&!empty($res['msg'])){
            $msg = $res['msg'];
        }
                        
        $result = array(
            "result" => array("code" => $code,"msg" => $msg)
        );
        if(!empty($data)){
            $result["data"] = $data;
        }else{
            $res["data"] = array();
        }
        echo json_encode($result);die;
    }
    
    public function getLastQuery(){
        $db = Database::instance();
        return $db->last_query;
    }
    public function getLastSQLError(){
        $db = Database::instance();
        return $db->last_error;
    }
    public function getUpdateId(){
        $db = Database::instance();
        return $db->last_update_id;
    }
}
?>