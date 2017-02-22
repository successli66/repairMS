<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {

    //制作验证码
    public function vercode() {
        $Verify = new \Think\Verify(array(
            'fontSize' => 25, // 验证码字体大小(px)
            'length' => 4, // 验证码位数
            'fontttf' => '', // 验证码字体，不设置随机获取
            'useNoise' => true, // 是否添加杂点
            'imageH' => 47, // 验证码图片高度
            'imageW' => 200, // 验证码图片宽度
        ));
        $Verify->entry();
    }
    
    //判断用户是否登陆
    public function login() {
        $aid = session('aid');
        if ($aid) {
            $this->redirect(U('Index/index'));
            exit;
        }
        $this->display();
    }
    
    //注销
    public function logout() {
        $model = D('User');
        $model->logout();
        redirect('login');
    }

    //ajax登陆
    public function ajaxLogin() {
        if (!IS_AJAX) {
            $this->error("提交方式错误！", true); //AJAX方式提交错误信息
            exit;
        } elseif (!IS_POST) {
            $this->error("提交方式错误！", true); //AJAX方式提交错误信息
            exit;
        } else {
            $model = D('User');
            if ($model->validate($model->_login_validate)->create()) {
                if ($model->login()) {
                    $this->success('登录成功！');
                    exit;
                }
            }
            $this->error($model->getError(), true); //AJAX方式提交错误信息
        }
    }

}
