<?php

namespace Admin\Controller;

class UserController extends BaseController {

    public function userInfo() {
        $data = session('user');
        $cpData = session('company');
        $dpData = session('department');
        $this->assign(array(
            'data' => $data,
            'cpData' => $cpData,
            'dpData' => $dpData
        ));
        $this->display();
    }

    public function edit() {
        if (IS_POST) {
            $moedl = D('user');
            $id = session('user')['id'];
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    session(null);
                    $uModel = M('user');
                    $user = $uModel->find($id);
                    $cpModel = M('Company');
                    $company = $cpModel->find($user['conpany_id']);
                    $dpModel = M('Department');
                    $department = $dpModel->find($user['department_id']);
                    session('user', $user);
                    session('company', $company);
                    session('department', $department);
                    $this->success('修改成功！', U('userInfo'), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $dpModel = M('Department');
        $dpData = $dpModel->select();
        $this->assign(array(
            'cpData' => $cpData,
            'dpData' => $dpData
        ));
        $this->display();
    }

    public function ajaxGetDep(){
        $company_id = I('get.company_id');
        $dpMoedl = M('Department');
        $data = $dpMoedl->where(array(
            'company_id'=>array('eq',$company_id),
        ));
        var_dump($data);
        var_dump($company_id);
        echo json_encode($$company_id);
    }
}
