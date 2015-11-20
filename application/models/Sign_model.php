<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/20
 * Time: 上午9:25
 */

class Sign_model extends CI_Model{



    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('PRC');
    }

    public function insert($user_id){
        $data = Array(
            "user_id" =>  $user_id,
            "sign_date" => date('y-m-d H:i:s',time())
        );

        $this->db->insert("sign", $data);
        return $this->db->insert_id();
    }
}