<?php

namespace Admin\Model;

use Think\Model;

class AdminModel extends Model {

    protected $insertFields = array('username', 'pwd','verify');
    protected $updateFields = array('id', 'username', 'password','password','repassword');
    //为登录表单定义一个验证规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('pwd', 'require', '密码不能为空！', 1),
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
        $pwd = $this->pwd;
        $user = $this->where(array(
            'username'=>$username,
        ))->find();
        if($user){
            if(md5($pwd) == $user['pwd']){
                //登录成功，保存session
                session('id',$user['id']);
                session('username',$user['username']);
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
