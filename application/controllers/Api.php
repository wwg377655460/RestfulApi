<?php
/**
 * Created by PhpStorm.
 * User: wsdevotion
 * Date: 15/11/18
 * Time: 下午4:58
 */


require_once APPPATH . "utils/HttpUtils.php";


class Api extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("please_model");
        $this->load->model("sign_model");
    }



    //注册
    public function insert(){
        $arr = HttpUtils::parseJson();
        if(!HttpUtils::validation($arr, ["name", "sex", "group_name", "imgurl", "phone", "position", "code"])){
            $this->varerror("参数匹配错误");
            return;
        }

        //判断用户名是否重复
        $user = $this->user_model->get_name($arr->name);
        if($user != null){
            $this->varerror("用户名重复");
            return;
        }
        //判断邀请码是否正确
        $code = $this->please_model->get($arr->code);
        if($code == null || $code["status"] == 0){
            $this->varerror("邀请码不存在");
            return;
        }else{
            $code["status"] = 0;
        }

        $this->db->trans_start();
        $this->please_model->update($code);
        $this->user_model->insert($arr);
        $this->db->trans_complete();
        $this->success(null);

    }

    //登录
    public function login(){
//        $arr = HttpUtils::parseJson();
//        if(!HttpUtils::validation($arr, ["name", "phone"])){
//            $this->varerror("参数匹配错误");
//            return;
//        }
        $name = $this->input->get("name");
        $phone = $this->input->get("phone");
        if($name == null || $phone == null){
            $this->varerror("参数匹配错误");
            return;
        }
        //判断用户名是否正确
        $user = $this->user_model->get_name($name);
        if($user == null || $user["phone"] != $phone){
            $this->varerror("用户名密码错误");
            return;
        }
//        print_r($user);
        $this->success($user);
        return;
    }

    //签到
    public function signin(){
        $arr = HttpUtils::parseJson();
        if(!HttpUtils::validation($arr, ["name"])){
            $this->varerror("参数匹配错误");
            return;
        }

        //判断用户当前状态
        $user = $this->user_model->get_name($arr->name);
        if($user["status"] == 1){
            $this->varerror("用户还没有下线");
            return;
        }else{
            $user["status"] = 1;
            $this->db->trans_start();
            $this->sign_model->insert($user["id"]);
            $this->user_model->update($user);
            $this->db->trans_complete();
            $this->success(null);
            return;
        }
    }

    //签退
    public function signout(){
        $arr = HttpUtils::parseJson();
        if(!HttpUtils::validation($arr, ["name"])){
            $this->varerror("参数匹配错误");
            return;
        }

        //判断用户当前状态
        $user = $this->user_model->get_name($arr->name);
        if($user["status"] == 0){
            $this->varerror("用户还没有签到");
            return;
        }else{
            $user["status"] = 0;
            $this->user_model->update($user);
            $this->success(null);
            return;
        }
    }

    //获取所有用户
    public function user(){
        $all = $this->user_model->get_all();
        $arr = Array(
            "status" => 1,
            "data" => $all
        );
        $this->success($arr);
        return;
    }

    //获取所有在线的用户
    public function user_sign(){
        $signs = $this->user_model->get_sign();
        $arr = Array(
            "status" => 1,
            "data" => $signs
        );
        $this->success($arr);
        return;
    }

    //修改用户信息
    public function user_change(){
        $arr = HttpUtils::parseJson();
        if(!HttpUtils::validation($arr, ["name", "sex", "group_name", "imgurl", "phone", "position"])){
            $this->varerror("参数匹配错误");
            return;
        }

        //判断用户名是否正确
        $user = $this->user_model->get_name($arr->name);
        if($user == null){
            $this->varerror("用户名信息错误");
            return;
        }

        $user['group_name'] = $arr->group_name;
        $user['imgurl'] = $arr->imgurl;
        $user['phone'] = $arr->phone;
        $user['position'] = $arr->position;
        $this->user_model->update($user);

//        print_r($user);
        $this->success($user);
        return;
    }


    //增加邀请码
    public function addplease($num){
        for($i = 0; $i < $num; $i++){
            $nums = HttpUtils::create_uuid();
            $arr = Array(
                  "num" =>$nums
            );
            $this->please_model->insert($arr);
        }

        $this->success(null);
        return;
    }

    //获取所有没有用的邀请码
    public function getplease(){
        $please = $this->please_model->get_all();
        $arr = Array(
            "status" => 1,
            "data" => $please
        );
        $this->success($arr);
        return;
    }

    private function varerror($meg){
        $arr = Array(
            "status" => -1,
            "message" => $meg
        );
        $this->output
            ->set_status_header(403)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($arr));
    }

    private function success($arr){
        if($arr == null){
            $arr = Array(
                "status" => 1
            );
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($arr));
    }

}