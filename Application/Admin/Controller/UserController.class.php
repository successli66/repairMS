<?php

namespace Admin\Controller;

class UserController extends BaseController {

    public function userList() {
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $dpModel = M('Department');
        $dpData = $dpModel->select();
        $this->assign(array(
            'cpData' => $cpData,
            'dpData' => $dpData
        ));
        $model = D('User');
        $data = $model->search();
        var_dump(I('get.'));
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }
    
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
    
    public function add() {
        if (IS_POST) {
            $model = D('User');
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功！', U('userList?p=' . I('get.p')), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign('cpData', $cpData);
        $this->display();
    }

    public function edit() {
        if (IS_POST) {
            $model = D('user');
            $id = session('user')['id'];
            $_POST['pw'] = md5($_POST['pw']);
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

    public function ajaxGetDep() {
        $company_id = I('get.company_id');
        $dpModel = M('Department');
        $dpData = $dpModel->where(array(
                    'company_id' => array('eq', $company_id),
                ))->select();
        echo json_encode($dpData);
    }
}
