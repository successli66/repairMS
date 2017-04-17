<?php

namespace Admin\Controller;

class RepairController extends BaseController {

    public function report() {
        if (IS_POST) {
            $model = D('Repair');
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('提交成功！', U('reportList'), 1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $prModel = M('Project');
        $prData = $prModel->select();
        $this->assign('prData', $prData);
        $this->display();
    }

    public function repairList() {
        $model = M('Repair');
        $data = $model->select();
        $this->assign(data, $data);
        $this->display();
    }

    public function search() {
        $model = D('Repair');
        $data = $model->search(15);
        $this->assign('data', $data);
        $this->display('repairList');
    }

    public function edit() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->find($id);
        if ($data['repair_status'] == '0') {
            $this->assign('data', $data);
            $this->display();
        } else {
            $this->error('报修已处理，不允许修改！', U('reportList?p=' . I('get.p')), 1);
        }
    }

    public function delete() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->find($id);
        if ($data['repair_status'] == '0') {
            if ($model->delete($id)) {
                $this->success('删除成功！', U('reportList'), 1);
            }
            $this->error($model->getError());
        } else {
            $this->error('报修已处理，不允许删除！', U('reportList?p=' . I('get.p')), 1);
        }
    }

}
