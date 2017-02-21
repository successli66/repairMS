<?php

namespace Admin\Model;

use Think\Model;

class UserModel extends Model {

    protected $insertFields = array('username','pw','verify');
    protected $updateFields = array('id', 'username', 'password','password','repassword');
    //为登录表单定义一个验证规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('pw', 'require', '密码不能为空！', 1),
        array('verify', 'require', '验证码不能为空！', 1),
        array('verify', 'check_vercode', '验证码错误！', 1, 'callback'),
    );

    //验证验证码是否正确
    function check_vercode($code, $id = '') {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    //用户登录
    public function login() {
        $username = $this->username;
        $pwd = $this->pw;
        $user = $this->where(array(
            'username'=>$username,
        ))->find();
        if($user){
            if(md5($pw) == $user['pw']){
                //登录成功，保存session
                session('user_id',$user['id']);
                session('username',$user['username']);
                session('real_name',$user['real_name']);
                session('work_number',$user['work_number']);
                session('post',$user['post']);
                session('portrait',$user['portrait']);
                session('department_id',$user['department_id']);
                session('company_id',$user['company_id']);
                return true;
            }else{
                $this->error = '用户名或密码错误！';
                return false;
            }
        }else{
            $this->error = '用户名或密码错误！';
            return false;
        }
    }
    
    //用户注销
    public function logout(){
        session(null);
    }

}
