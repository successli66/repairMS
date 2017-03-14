<?php

namespace Admin\Controller;

class UserController extends BaseController {

    public function info() {
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
            $model = D('user');
            $id = session('user')['id'];
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    session(null);
                    $user = $model->find($id);
                    $cpModel = M('Company');
                    $company = $cpModel->find($user['conpany_id']);
                    $dpModel = M('Department');
                    $department = $dpModel->find($user['department_id']);
                    session('user', $user);
                    session('company', $company);
                    session('department', $department);
                    $this->success('修改成功！', U('info'), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $dpModel = D('Department');
        $dpData = $dpModel->getDpByCpId(session('user')['company_id']);
        $this->assign(array(
            'cpData' => $cpData,
            'dpData' => $dpData
        ));
        $this->display();
    }

    public function editPw() {
         if (IS_POST) {
            $model = D('User');
            if ($model->validate($model->_editPw_validate)->create(I('post.'), 2)) {
                $id = session('user')['id'];
                $data['pw'] = md5($_POST['pw']);
                $uData = $model->find($id);
                if ($uData['pw'] === $data['pw']) {
                    $this->success('修改密码成功！', U('userList?p=' . I('get.p',1)), 1);
                    exit;
                }
                if ($model->where(array('id' => $id))->save($data)) {
                    $this->success('修改密码成功！', U('userList?p=' . I('get.p',1)), 1);
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    public function userList() {
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign(array(
            'cpData' => $cpData,
        ));
        $model = D('User');
        $data = $model->search();
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }
    
    public function userInfo() {
        $id = I('get.id');
        $model = M('User');
        $data = $model->find($id);
        $cpModel = M('Company');
        $cpData = $cpModel->find($data['company_id']);
        $dpModel = M('Department');
        $dpData = $dpModel->find($data['department_id']);
        $this->assign(array(
            'data' => $data,
            'cpData' => $cpData,
            'dpData' => $dpData
        ));
        $this->display();
    }

    public function userAdd() {
        if (IS_POST) {
            $model = D('User');
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功！', U('userList?p=' . I('get.p',1)), 1);
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

    public function userEdit() {
        if (IS_POST) {
            $model = D('user');
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    $this->success('修改成功！', U('userList?p=' . I('get.p',1)), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $model = M('User');
        $data = $model->find($id);
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $dpModel = D('Department');
        $dpData = $dpModel->getDpByCpId($data['company_id']);
        $this->assign(array(
            'data' => $data,
            'cpData' => $cpData,
            'dpData' => $dpData,
        ));
        $this->display();
    }

    public function userEditPw() {
        if (IS_POST) {
            $model = D('User');
            if ($model->validate($model->_editPw_validate)->create(I('post.'), 2)) {
                $id = I('get.id');
                $data['pw'] = md5($_POST['pw']);
                $uData = $model->find($id);
                if ($uData['pw'] === $data['pw']) {
                    $this->success('修改密码成功！', U('userList?p=' . I('get.p',1)), 1);
                    exit;
                }
                if ($model->where(array('id' => $id))->save($data)) {
                    $this->success('修改密码成功！', U('userList?p=' . I('get.p'),1), 1);
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }
    
    public function userDelet(){
        $id = I('get.id');
        $model = M('User');
        if($model->delete($id)){
            $this->success('删除成功！',U('userList'),1);
            exit();
        }
        $this->error($model->getError());
    }
    
    public function addressBook() {
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign(array(
            'cpData' => $cpData,
        ));
        $model = D('User');
        $data = $model->search();
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

}
