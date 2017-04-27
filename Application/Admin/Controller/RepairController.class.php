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
        if ($data['repair_status'] == 1) {
            $data['next'] = 'select';
        }
        if ($data['repair_status'] == 2) {
            $data['next'] = 'repaired';
        }
        if ($data['repair_status'] == 3) {
            $data['next'] = 'end';
        }
        $this->assign(array(
            'data' => $data,
        ));
        $this->display();
    }

    public function detail() {
        $id = I('get.id');
        $model = D('Repair');
        $data = $model->findById($id);
        $this->assign(array(
            'data' => $data,
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
                exit;
            }
            $this->error($model->getError());
        } else {
            $this->error('报修已处理，不允许删除！', U('repairList?p=' . I('get.p')), 1);
        }
    }

    public function select() {
        if (IS_POST) {
            $model = D('Repair');
            if ($model->create(I('post.'), 2)) {
                if ($this->eventAdd()) {
                    if ($model->save($_POST)) {//add()必须加$_POST,否则添加的ueditor内容不能正常显示
                        $this->success('保存成功！', U('info', array('id' => I('get.id'), 'p' => I('get.p'))), 0);
                        exit();
                    }
                } else {
                    $this->error($model->getError());
                }
                $this->error($evModel->getError());
            }
        }
        $team = explode(',', $pjData['team']);
        $uModel = M('User');
        $uData = array();
        foreach ($team as $k => $v) {
            $uData[] = $uModel->find($v);
        }
        $auData = $uModel->select();
        $this->assign('team', $team);
        $this->assign('auData', $auData);
        $this->display();
    }

    public function eventAdd() {
        $time = date('Y-m-d H:i:s', time());
        $event['event_type'] = $_POST['event_type'];
        $event['event_name'] = $_POST['event_name'];
        $event['repair_id'] = $_POST['repair_id'];
        $event['event_value'] = implode(',', $_POST['repair_user_id']);
        $event['user_id'] = session('user')['id'];
        $event['event_time'] = $time;
        $evModel = M('Event');
        if ($evModel->add($event)) {
            return TRUE;
        } else {
            
        }
    }

}
