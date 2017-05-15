<?php

namespace Admin\Controller;

class GroupController extends BaseController {

    public function groupList() {
        $model = D('group');
        $data = $model->get_tree();
        $this->assign('data', $data);
        $this->display();
    }

    public function search() {
        $model = D('group');
        $data = $model->search();
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display('groupList');
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
                $this->error('该组中有子分组，请先删除所有子分组，再删除该组！', U('groupList'), 3);
                exit;
            }
        }
        if ($model->delete($id)) {
            $this->success('删除成功！', U('groupList'), 1);
            exit;
        }
        $this->error($model->getError());
    }

    public function distribute_user() {
        $guModel = M('group_user');
        if (IS_POST) {
            if (!empty($_POST['user_id'])) {
                $guModel->where(array(
                    'group_id'=>$_POST['group_id']
                ))->delete();
                foreach ($_POST['user_id'] as $k => $v) {
                    $group_user['user_id'] = $v;
                    $group_user['group_id'] = $_POST['group_id'];
                    $guModel->add($group_user);
                }
                $this->success('分配成功！', U('groupList'), 1);
                exit;
            }
            $this->error('必须选择至少一个成员！',U('groupList'), 2);
        }
        $group_id = I('get.id');
        $guData = $guModel->where(array(
                    'group_id' => $group_id
                ))->select();
        $uModel = D('user');
        $uData = $uModel->search(10000);
        foreach($guData as $k=>$v){
            $group_ids[] = $v['id'];
        }
        $this->assign('uData', $uData);
        $this->assign('guData', $guData);
        $this->assign('group_ids', $group_ids);
        $this->display();
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

}
