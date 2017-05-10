<?php

namespace Admin\Controller;

class PrivilegeController extends BaseController {

    public function privilegeList() {
        $model = D('privilege');
        $data = $model->get_tree();
        $this->assign('data', $data);
        $this->display();
    }
    
    public function search() {
        $model = D('privilege');
        $data = $model->search();
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display('privilegeList');
    }

    public function add() {
        $model = D('privilege');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add($_POST)) {
                    $this->success('添加成功！', U('privilegeList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
                $this->error($model->getError());
            }
        }
        $data = $model->get_tree();
        $this->assign('data', $data);
        $this->display();
    }

    public function edit() {
        $model = D('privilege');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save($_POST)) {
                    $this->success('修改成功！', U('privilegeList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $data = $model->find($id);
        $privilegeData = $model->get_tree();
        $this->assign('data', $data);
        $this->assign('privilegeData', $privilegeData);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('privilege');
        if ($id == 1) {
            $this->error('超级管理员组不允许删除！', U('privilegeList'), 1);
            exit;
        }
        $grData = $model->select();
        foreach ($grData as $k => $v) {
            if ($v['parent_id'] == $id) {
                $this->error('该组中有子分组，请先删除所有子分组，再删除该组！', U('privilegeList'), 3);
                exit;
            }
        }
        if ($model->delete($id)) {
            $this->success('删除成功！', U('privilegeList'), 1);
            exit;
        }
        $this->error($model->getError());
    }

    public function distribute_privilege() {
        $uModel = M('user');
        if (IS_POST) {
            foreach ($_POST['user_id'] as $k => $v) {
                $user['id'] = $v;
                $user['privilege_id'] = $_POST['privilege_id'];
                $uModel->save($user);
            }
            $this->success('分配成功！', U('privilegeList'), 1);
            exit;
        }
        $uData = $uModel->select();
        $this->assign('uData', $uData);
        $this->display();
    }

    public function distribute_user() {
        $uModel = M('user');
        if (IS_POST) {
            foreach ($_POST['user_id'] as $k => $v) {
                $user['id'] = $v;
                $user['privilege_id'] = $_POST['privilege_id'];
                $uModel->save($user);
            }
            $this->success('分配成功！', U('privilegeList'), 1);
            exit;
        }
        $uData = $uModel->select();
        $this->assign('uData', $uData);
        $this->display();
    }

}
