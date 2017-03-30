<?php

namespace Admin\Controller;

class EquipmentController extends BaseController {

    public function equipmentList() {
        $model = D('Equipment');
        $data = $model->search();
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
            'cpData' => $cpData
        ));
        $this->display();
    }

    public function info() {
        $id = I('get.id');
        $model = M('Equipment');
        $data = $model->find($id);
        $cpModel = M('Company');
        $cpData = $cpModel->find($data['company_id']);
        $pdData = $this->getPjAndDp($data['projcet_id']);
        $this->assign('data', $data);
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->assign('cpData', $cpData);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            $model = D('Equipment');
            if ($model->create(I('post.'), 1)) {
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击
                if ($model->add($_POST)) {
                    $this->success('添加成功！', U('equipmentList', array('project_id' => I('get.project_id'), 'p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $pdData = $this->getPjAndDp(I('get.project_id'));
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->assign('cpData', $cpData);
        $this->display();
    }

    public function edit() {
        $model = D('Equipment');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击 
                if ($model->save($_POST)) {
                    $this->success('修改成功！', U('equipmentList', array('project_id' => I('get.project_id'), 'p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $id = I('get.id');
        $data = $model->find($id);
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $pdData = $this->getPjAndDp($data['projcet_id']);
        $this->assign('data', $data);
        $this->assign('pjData', $pdData['pjData']);
        $this->assign('dpData', $pdData['dpData']);
        $this->assign('cpData', $cpData);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('Equipment');
        if ($model->delete($id)) {
            $this->success('删除成功！', U('equipmentList', array('project_id' => I('get.project_id'))), 1);
            exit;
        } else {
            $this->error($model->getError());
        }
    }

//    public function search() {
//        $model = D('Equipment');
//        $data = $model->search();
//        $this->assign(array(
//            'data' => $data['data'],
//            'page' => $data['page'],
//        ));
//        $this->display('equipmentList');
//    }

    protected function getPjAndDp($pjId) {//获得项目和部门名称
        $pjModel = M('Project');
        $pjData = $pjModel->find($pjId);
        $dpModel = M('Department');
        $dpId = $pjData['department_id'];
        $dpData = $dpModel->find($dpId);
        $pdData['pjData'] = $pjData;
        $pdData['dpData'] = $dpData;
        return $pdData;
    }

    public function ajaxGetEq() {
        $projectId = I('get.project_id');
        $eqModel = D('Equipment');
        $eqData = $eqModel->getEqByPj($projectId);
        echo json_encode($eqData);
    }

}
