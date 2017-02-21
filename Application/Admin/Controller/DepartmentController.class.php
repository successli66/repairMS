<?php

namespace Admin\Controller;

/**
 * Description of DepartmentController
 *
 * @author LI
 */
class DepartmentController extends BaseController {

    public function departmentList() {
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign('cpData', $cpData);
        $model = D('department');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();      
    }

    public function add() {
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        if (IS_POST) {
            $model = D('Department');
            if ($model->create(I('post.'),1)) {
                if ($id = $model->add()) {
                    $this->success('添加成功！', U('departmentList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $this->assign('cpData',$cpData);
        $this->display();
    }

    public function edit() {
        $model = D('Department');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    $this->success('修改成功！', U('departmentList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $data = $model->find(I('get.id'));
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign('data', $data);
        $this->assign('cpData',$cpData);
        $this->display();
    }

    public function delet() {
        $id = I('get.id');
        $model = D('Department');
        if ($model->delete($id)) {
            $this->success('删除成功！', U('departmentList'), 1);
            exit;
        } else {
            $this->error($model->getError());
        }
    }

    public function search() {
        $model = D('Department');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $cpModel = M('Company');
        $cpData = $cpModel->select();
        $this->assign('cpData', $cpData);
        $this->display('departmentList');
    }

}
