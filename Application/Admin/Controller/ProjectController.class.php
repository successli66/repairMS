<?php

namespace Admin\Controller;

class ProjectController extends BaseController {

    public function projectList() {
        $model = D('Project');
        $admin = array(1); //用户分组待完善
        if (in_array(session('user')['id'], $admin)) {
            $data = $model->search();
        } else {
            $data = $model->where(array('department_id' => session('user')['department_id']))->search();
        }
        foreach ($data['data'] as $k => &$v) {//循环获得每条数据获得team元素
//            $dpData = $dpModel->find($v['department_id']);
//            $v['department_name'] = $dpData['department_name'];
//            $team = explode(',', $v['team']); //将team元素字符串转换为数组
//            $user = array();
//            foreach ($team as $k1 => $v1) {//循环team数组，取得用户名
//                $uData = $uModel->find($v1);
//                $user[] = $uData['real_name']; //获得用户名数组
//            }
//            $user = implode(',', $user); //用户名数组转换为字符串
//            $v['team_name'] = $user;
            $tdData = $this->getTmAndDp($v);
            $v['team_name'] = $tdData['team_name'];
            $v['department_name'] = $tdData['department_name'];
        }
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();
    }

    public function info() {
        $id = I('get.id');
        $model = M('Project');
        $data = $model->find($id);
        $tdData = $this->getTmAndDp($data);
        $data['team'] = explode(',', $data['team']); //字符串转换为数组
        $data['team_name'] = explode(',', $tdData['team_name']);
        $data['department_name'] = $tdData['department_name'];
        $this->assign('data', $data);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            $model = D('Project');
            if ($model->create(I('post.'), 1)) {
                $_POST['team'] = implode(',', $_POST['team']);
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击
                if ($id = $model->add($_POST)) {//add()需要加$_POST,否则添加的ueditor内容不能正常显示
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
        $this->assign("uData", $uData['data']);
        $this->assign("dpData", $dpData);
        $this->display();
    }

    public function edit() {
         $model = D('Project');
         if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                $_POST['team'] = implode(',', $_POST['team']);
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击
                if ($model->save($_POST)) {
                    $this->success('修改成功！', U('projectList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $data = $model->find($id);
        $tdData = $this->getTmAndDp($data);
        $data['team'] = explode(',', $data['team']); //字符串转换为数组
        $data['team_name'] = explode(',', $tdData['team_name']);
        $data['department_name'] = $tdData['department_name'];
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
        $this->assign('data', $data);
        $this->assign('dpData', $dpData);
        $this->assign('uData', $uData['data']);
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

    protected function getTmAndDp($data) {//获得一个项目的维修团队和部门名称
        $uModel = M('User');
        $dpModel = M('Department');
        $dpData = $dpModel->find($data['department_id']);
        $tdData['department_name'] = $dpData['department_name'];
        $team = explode(',', $data['team']); //将team元素字符串转换为数组
        $name = array();
        foreach ($team as $k1 => $v1) {//循环team数组，取得用户名
            $uData = $uModel->find($v1);
            $name[] = $uData['real_name']; //获得用户名数组
        }
        $tdData['team_name'] = implode(',', $name); //用户名数组转换为字符串
        return $tdData;
    }

}
