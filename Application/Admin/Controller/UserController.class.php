<?php

namespace Admin\Controller;

class UserController extends BaseController{
    public function userInfo(){
        $data = session('user');
        $cpData = session('company');
        $dpData = session('department');
        $this->assign(array(
            'data'=>$data,
            'cpData'=>$cpData,
            'dpData'=>$dpData
        ));
        $this->display();
    }
    
    
    
}

