<?php

namespace Admin\Controller;

/**
 * Description of DepartmentController
 *
 * @author LI
 */
class DepartmentController extends BaseController {

    public function departmentList() {
        $model = D('department');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        var_dump($data);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            $model = D('Department');
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功！', U('departmentList', array('p' => I('get.p', 1))), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    public function edit() {
        $id = I('get.id');
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
        $data = $model->find($id);
        $this->assign('data', $data);
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
        var_dump($data);
        $this->display('departmentList');
    }

}
