<?php

namespace Admin\Controller;

class GroupController extends BaseController {

    public function groupList() {
        $model = D('group');
        $data = $model->get_tree();
        $this->assign('data', $data);
        $this->display();
    }

    public function add() {
        $model = D('group');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add($_POST)) {
                    $this->success('添加成功！', U('groupList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
                $this->error($model->getError());
            }
        }
        $data = $model->get_tree();
        $this->assign('data', $data);
        var_dump($data);
        $this->display();
    }

    public function edit() {
        $model = D('group');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save($_POST)) {
                    $this->success('修改成功！', U('groupList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $data = $model->find($id);
        $groupData = $model->get_tree();
        $this->assign('data', $data);
        $this->assign('groupData', $groupData);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('group');
        if ($id == 1) {
            $this->error('超级管理员组不允许删除！', U('groupList'), 1);
            exit;
        }
        $grData = $model->select();
        foreach ($grData as $k => $v) {
            if ($v['parent_id'] == $id) {
                $this->error('您要删除的分组中有子分组，请先删除所有子分组，再删除该组！', U('groupList'), 3);
                exit;
            }
        }
        if ($model->delete($id)) {
            $this->success('删除成功！', U('groupList'), 1);
            exit;
        }
        $this->error($model->getError());
    }

    public function distribute_privilege() {
        $uModel = M('user');
        if (IS_POST) {
            foreach ($_POST['user_id'] as $k => $v) {
                $user['id'] = $v;
                $user['group_id'] = $_POST['group_id'];
                $uModel->save($user);
            }
            $this->success('分配成功！', U('groupList'), 1);
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
                $user['group_id'] = $_POST['group_id'];
                $uModel->save($user);
            }
            $this->success('分配成功！', U('groupList'), 1);
            exit;
        }
        $uData = $uModel->select();
        $this->assign('uData', $uData);
        $this->display();
    }

}
