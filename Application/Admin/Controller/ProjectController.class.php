<?php

namespace Admin\Controller;

class ProjectController extends BaseController {

    public function projectList() {
        $model = D('Project');
        $uModel = M('User');
        $dpModel = M('Department');
        $admin = array(1); //用户分组待完善
        if (in_array(session('user')['id'], $admin)) {
            $data = $model->search();
        } else {
            $data = $model->where(array('department_id' => session('user')['department_id']))->search();
        }
        foreach ($data['data'] as $k => &$v) {//循环获得每条数据获得team元素
            $dpData = $dpModel->find($v['deparment_id']);
            $v['department_name'] = $dpData['department_name'];
            $team = explode(',', $v['team']); //将team元素字符串转换为数组
            $user = array();
            foreach ($team as $k1 => $v1) {//循环team数组，取得用户名
                $uData = $uModel->find($v1);
                $user[] = $uData['real_name']; //获得用户名数组
            }
            $user = implode(',', $user); //用户名数组转换为字符串
            $v['team_name'] = $user;
        }
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            $model = D('project');
            if ($model->create(I('post.'), 1)) {
                $_POST['team'] = implode(',', $_POST['team']);
                //$_POST['desc'] = removeXSS($_POST['desc']); //防止xss攻击
                var_dump($_POST);
                if ($id = $model->add($_POST)) {
                    $this->success('添加成功！', U('projectList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $admin = array(1); //超级管理员id，分组功能待完善！！！
        if (in_array(session('user')['id'], $admin)) {
            //超级管理员允许修改所有部门项目
            $uModel = D('User');
            $uData = $uModel->getUserByCp(session('user')['company_id']); //获得本公司人员
            $dpModel = D('Department');
            $dpData = $dpModel->getDpByCpId(session('user')['company_id']); //获得本公司部门
        } else {
            //普通管理员只允许修改本部门项目
            $uModel = D('User');
            $uData = $uModel->getUserByDp(session('user')['department_id']); //获得本部门人员
            $dpData[] = array(//构造出本部门数据数组
                'id' => session('department')['id'],
                'department_name' => session('department')['department_name']
            );
        }
        $this->assign("uData", $uData);
        $this->assign("dpData", $dpData);
        $this->display();
    }

    public function edit() {
        $id = I('get.id');
        $model = D('Company');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    $this->success('修改成功！', U('companyList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $data = $model->find($id);
        $this->assign('data', $data);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('Company');
        if ($model->delete($id)) {
            $this->success('删除成功！', U('companyList'), 1);
            exit;
        } else {
            $this->error($model->getError());
        }
    }

    public function search() {
        $model = D('Company');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display('companyList');
    }

}
