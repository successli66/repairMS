<?php

namespace Admin\Controller;

class PartController extends BaseController {

    public function partList() {
        $model = D('Part');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();
    }

    public function info() {
        $id = I('get.id');
        $model = M('Part');
        $data = $model->find($id);
        $pdData = $this->getPjAndDp($data['projcet_id']);
        $this->assign('data', $data);
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            $model = D('Part');
            if ($model->create(I('post.'), 1)) {
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击
                if ($model->add($_POST)) {
                    $this->success('添加成功！', U('partList', array('project_id'=>I('get.project_id'),'p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $pdData = $this->getPjAndDp(I('get.project_id'));
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->display();
    }

    public function edit() {
        $model = D('Part');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击 
                if ($model->save($_POST)) {  
                    $this->success('修改成功！', U('partList', array('project_id'=>I('get.project_id'),'p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $data = $model->find($id);
        $pdData = $this->getPjAndDp($data['projcet_id']);
        $this->assign('data', $data);
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('Part');
        if ($model->delete($id)) {
            $this->success('删除成功！', U('partList',array('project_id'=>I('get.project_id'))), 1);
            exit;
        } else {
            $this->error($model->getError());
        }
    }

    public function search() {
        $model = D('Part');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display('partList');
    }

    protected function getPjAndDp($pjId) {//获得一个项目的维修团队和部门名称
        $pjModel = M('Project');
        $pjData = $pjModel->find($pjId);
        $dpModel = M('Department');
        $dpId = $pjData['department_id'];
        $dpData = $dpModel->find($dpId);
        $pdData['pjData'] = $pjData;
        $pdData['dpData'] = $dpData;
        return $pdData;
    }

}
