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
                    'group_id' => $_POST['group_id']
                ))->delete();
                foreach ($_POST['user_id'] as $k => $v) {
                    $group_user['user_id'] = $v;
                    $group_user['group_id'] = $_POST['group_id'];
                    $guModel->add($group_user);
                }
                $this->success('分配成功！', U('groupList'), 1);
                exit;
            }
            $this->error('必须选择至少一个成员！', U('groupList'), 2);
        }
        //查询group_user表中group_id为$group_id的数据
        $group_id = I('get.id');
        $guData = $guModel->where(array(
                    'group_id' => $group_id
                ))->select();
        $uModel = D('user');
        //获得所有用户数据
        $uData = $uModel->search(10000);
        foreach ($guData as $k => $v) {
            $user_ids[] = $v['user_id'];
        }
        $this->assign('uData', $uData);
        $this->assign('guData', $guData);
        $this->assign('user_ids', $user_ids);
        $this->display();
    }

    public function distribute_privilege() {
        $gpModel = M('group_privilege');
        $group_id = I('get.id');
        if (IS_POST) {
            if (!empty($_POST['privilege_id'])) {
                $gpModel->where(array(
                    'group_id' => $_POST['group_id']
                ))->delete(); //先删除原权限
                foreach ($_POST['privilege_id'] as $k => $v) {//再添加新权限
                    $group_privilege['privilege_id'] = $v;
                    $group_privilege['group_id'] = $_POST['group_id'];
                    $gpModel->add($group_privilege);
                }
                $this->success('分配成功！', U('groupList'), 1);
                exit;
            }
            $this->error('必须选择至少一个权限！', U('groupList'), 2);
        }
        $gpData = $gpModel->where(array(
                    'group_id' => $group_id,
                ))->select(); //获得此组的所有权限
        foreach ($gpData as $k => $v) {
            $privilege_ids[] = $v['privilege_id'];
        }//获得此组权限的所有id，组成一个以为数组
        $pModel = D('privilege');
        $pData = $pModel->get_tree();
        $i = 0;
        $level = array();
        foreach ($pData as $k => $v) { //对权限数据进行分层处理，同一控制器下方法放到一层中
            if ($v['level'] == 0) {
                $i++;
            }
            $level[$i][] = $v;
        }
        $this->assign('gpData', $gpData);
        $this->assign('level', $level);
        $this->assign('privilege_ids', $privilege_ids);
        $this->display();
    }

}
