<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/18
 * Time: 下午5:24
 */

class User_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('PRC');
    }

    public function insert($array){
        $data = Array(
            'name' => $array->name,
            'sex' => $array->sex,
            'description' => $array->description,
            'group_name' => $array->group_name,
            'imgurl' => $array->imgurl,
            'phone' => $array->phone,
            'sign_date' => date('y-m-d H:i:s',time()),
            'position' => $array->position
        );

        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function lock(){
        $sql_1=" LOCK TABLES users read ";
        return $this->db->query($sql_1);
    }

    public function unlock(){
        $sql_2=" UNLOCK TABLES ";
        return $this->db->query($sql_2);
    }

    public function get($id){
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }

    public function get_sign(){
        $this->db->order_by("group_name", "desc");
        $query = $this->db->get_where('users', array('status' => 1));
        return $query->result_array();
    }

    public function get_name($name){
        $query = $this->db->get_where('users', array('name' => $name));
        return $query->row_array();
    }

    public function get_all(){
        $this->db->order_by('group_name', 'desc');
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function update($array){
        $this->db->where('id', $array['id']);
        $this->db->update('users', $array);
    }


}