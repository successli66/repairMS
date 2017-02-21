<?php

namespace Admin\Controller;

class CompanyController extends BaseController {

    public function companyList() {
        $model = D('Company');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();
    }

    public function add() {
        if (IS_POST) {  
            $model = D('Company');
            if ($model->create(I('post.'),1)) {
                if ($id = $model->add()) {
                    $this->success('添加成功！', U('companyList',array('p' => I('get.p', 1))),1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
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
    
    public function search(){
        $model = D('Company');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display('companyList');    
    }

}
