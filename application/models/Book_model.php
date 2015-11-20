<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/18
 * Time: 下午5:49
 */

class Book_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('PRC');
    }

    public function insert($array){
        $this->db->insert('book', $array);
        return $this->db->insert_id();
    }
}