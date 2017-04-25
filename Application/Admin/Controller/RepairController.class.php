<?php

namespace Admin\Controller;

class RepairController extends BaseController {

    public function report() {
        if (IS_POST) {
            $model = D('Repair');
            if ($model->create(I('post.'), 1)) {
                $_POST['descr'] = removeXSS($_POST['descr']); //防止xss攻击
                if ($model->add($_POST)) {//add()必须加$_POST,否则添加的ueditor内容不能正常显示
                    $this->success('报修成功！', U('repairList'), 1);
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
        $order_time = date('YmdHis') . rand(10, 99);
        $model = D('Repair');
        $data = $model->search(2);
        $this->assign(data, $data['data']);
        $this->assign(page, $data['page']);
        $this->display();
    }

    public function search() {
        $model = D('Repair');
        $data = $model->search(15);
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display('repairList');
    }

        public function info() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->findById($id);
        $this->assign(array(
            'data'=>$data,
        ));
        $this->display();  
    }
    
    public function detail() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->findById($id);
        $this->assign(array(
            'data'=>$data,
        ));
        $this->display();      
    }

    public function edit() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->find($id);
        if ($data['repair_status'] == '1') {
            $this->assign('data', $data);
            $this->display();
        } else {
            $this->error('报修已处理，不允许修改！', U('repairList?p=' . I('get.p')), 3);
        }
    }

    public function delete() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->find($id);
        if ($data['repair_status'] == '0') {
            if ($model->delete($id)) {
                $this->success('删除成功！', U('repairList'), 1);
            }
            $this->error($model->getError());
        } else {
            $this->error('报修已处理，不允许删除！', U('repairList?p=' . I('get.p')), 1);
        }
    }

}
