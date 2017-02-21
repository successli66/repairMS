<?php

namespace Admin\Controller;

class UserController extends BaseController{
    public function userInfo(){
        $data = session('user');
        $cpModel = D('Company');
        $cpData = $cpModel->find($data['company_id']);
        $dpModel = M('Department');
        $dpData = $dpModel->find($data['department_id']);
        $this->assign(array(
            'data'=>$data,
            'cpData'=>$cpData,
            'dpData'=>$dpData
        ));

        $this->display();
    }
}

