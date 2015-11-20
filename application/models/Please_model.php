<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/20
 * Time: 上午9:34
 */

class Please_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('PRC');
    }

    public function get_all(){
        $query = $this->db->get_where('please', array('status' => 1));
        return $query->result_array();
    }

    public function insert($array){
        $this->db->insert('please', $array);
        return $this->db->insert_id();
    }

    public function update($array){
        $this->db->where('id', $array['id']);
        $this->db->update('please', $array);
    }

    public function get($num){
        $query = $this->db->get_where('please', array('num' => $num));
        return $query->row_array();
    }


}