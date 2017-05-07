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
        $newRepairCount = $model->where(array(
                    'repair_status' => 1
                ))->count();
        $repairingCount = $model->where(array(
                    'repair_status' => 2
                ))->count();
        $repairedCount = $model->where(array(
                    'repair_status' => 3
                ))->count();
        session('newRepairCount', $newRepairCount);//重新存储新报修的数目
        session('repairingCount', $repairingCount);//重新存储维修中的数目
        session('repairedCount', $repairedCount);//重新存储已维修的数目
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
        $repair_id = I('get.id');
        $model = D('Repair');
        $data = $model->findById($repair_id);
        $evData = array();
        if ($data['repair_status'] == 1) {//新报送
            $data['next'] = 'select';
        }
        if ($data['repair_status'] == 2) {//接报状态（办理状态）
            $data['next'] = 'repaired';
            $evData[] = $this->getEvent(1, $repair_id);
        }
        if ($data['repair_status'] == 3) {//维修完状态
            $data['next'] = 'end';
            $evData[] = $this->getEvent(1, $repair_id);
            $evData[] = $this->getEvent(2, $repair_id);
            $fData = $this->getFee($repair_id);
        }
        if ($data['repair_status'] == 4) {//办结状态
            $evData[] = $this->getEvent(1, $repair_id);
            $evData[] = $this->getEvent(2, $repair_id);
            $evData[] = $this->getEvent(3, $repair_id);
            $fData = $this->getFee($repair_id);
        }
        $this->assign(array(
            'data' => $data,
            'evData' => $evData, //三维数组
            'fData' => $fData
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

    public function select() { //选择预约维修时间和维修人
        if (IS_POST) {
            $model = M('repair');
            $repair['repair_status'] = 2;
            $repair['id'] = $_POST['repair_id'];
            $model->save($repair);
            if ($this->eventAdd()) {
                $this->success('保存成功！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 0);
                exit();
            }
            $this->error($model->getError());
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

    public function edit_select() {
        $repair_id = I('get.repair_id');
        if (IS_POST) {
            $evModel = M('event');
            $_POST['event_value'] = implode(',', $_POST['repair_user_id']);
            $_POST['event_time'] = date('Y-m-d H:i:s', time());
            if ($evModel->save($_POST)) {
                $this->success('保存成功！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 0);
                exit();
            }
            $this->error($evModel->getError());
        }
        $evData = $this->getEvent(1, $repair_id);
        $uModel = M('user');
        var_dump($repair_id);
        $auData = $uModel->select();
        $this->assign('evData', $evData);
        $this->assign('auData', $auData);
        $this->display();
    }

    public function repaired() { //维修完成
        $repair_id = I('get.repair_id');
        if (IS_POST) {
            if ($this->eventAdd($repair_id)) {//添加事件  
                $this->addFee($repair_id);   //添加费用
                $model = M('repair');
                $repair['repair_status'] = 3;
                $repair['id'] = $repair_id;
                $model->save($repair);
                $this->success('提交完成！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 0);
                exit();
            }
        }
        $uModel = M('user');
        $uData = $uModel->select();
        $evData = $this->getEvent(1, $repair_id); //获得type=1(办理)的事件信息
        $project_id = I('get.project_id');
        $paModel = M('part');
        $paData = $paModel->where(array(
                    'project_id' => $project_id,
                ))->select();
        $this->assign(array(
            'uData' => $uData,
            'evData' => $evData,
            'paData' => $paData,
        ));
        $this->display();
    }

    public function edit_repaired() {
        $repair_id = I('get.repair_id');
        if (IS_POST) {
            $evModel = M('event');
            $_POST['event_value'] = implode(',', $_POST['repair_user_id']);
            $_POST['event_time'] = date('Y-m-d H:i:s', time());
            if ($evModel->save($_POST)) {//修改event表数据
                $fModel = M('fee');
                $fModel->where(array('repair_id' => $repair_id))->delete(); //删除费用表对应的repair_id数据
                $this->addFee($repair_id); //重新添加fee表的数据
                $this->success('保存成功！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 0);
                exit();
                $this->error($fModel->getError());
            }
            $this->error($evModel->getError());
        }
        $uModel = M('user');
        $uData = $uModel->select();
        $evData = $this->getEvent(2, $repair_id); //获得type=2(维修完)的事件信息
        $fData = $this->getFee($repair_id);
        $part_id = array();
        foreach ($fData as $k => $v) {
            if ($v['fee_item'] != 0) {
                $part_id[] = $v['fee_item'];
            }
        }
        $project_id = I('get.project_id');
        $paModel = M('part');
        $paData = $paModel->where(array(
                    'project_id' => $project_id,
                ))->select();
        $this->assign(array(
            'uData' => $uData,
            'evData' => $evData,
            'paData' => $paData,
            'fData' => $fData,
            'part_id' => $part_id,
        ));
        $this->display();
    }

    public function end() {
        if (IS_POST) {
            if ($this->eventAdd()) {
                $model = M('repair');
                $repair['repair_status'] = 4;
                $repair['id'] = $_POST['repair_id'];
                $model->save($repair);
                $this->success('办结成功！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 1);
                exit();
            }
        }
        $this->display();
    }

    public function edit_end() {
        $repair_id = I('get.repair_id');
        if (IS_POST) {
            if ($this->eventAdd()) {
                $model = M('repair');
                $repair['repair_status'] = 4;
                $repair['id'] = $_POST['repair_id'];
                $model->save($repair);
                $this->success('办结成功！', U('info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 1);
                exit();
            }
        }
        $evModel = M('event');
        $evData = $evModel->where(array(
                    'repair_id' => $repair_id,
                    'event_type' => 3
                ))->find();
        $this->assign('evData', $evData);
        $this->display();
    }

    public function cancel() {
        $repair_id = I('get.repair_id');
        $model = M('repair');
        $repair['repair_status'] = 3;
        $repair['id'] = $repair_id;
        if ($model->save($repair)) {
            $evModel = M('event');
            $ev = $evModel->where(array(
                        'repair_id' => $repair_id,
                        'event_type' => 3
                    ))->delete();
            if ($ev) {
                $this->success('修改成功！', U('Info', array('id' => I('get.repair_id'), 'p' => I('get.p'))), 1);
                exit;
            }
        }
    }

    public function eventAdd() { //添加事件
        $time = date('Y-m-d H:i:s', time());
        $event['event_type'] = $_POST['event_type'];
        $event['event_name'] = $_POST['event_name'];
        $event['repair_id'] = $_POST['repair_id'];
        $event['event_value'] = implode(',', $_POST['repair_user_id']);
        $event['user_id'] = session('user')['id'];
        $event['event_time'] = $time;
        $event['repair_time'] = $_POST['repair_time'];
        $event['descr'] = $_POST['descr'];
        $event['repair_id_event_type'] = $_POST['repair_id'] . $_POST['event_type'];
        $evModel = M('Event');
        if ($evModel->add($event)) {
            return TRUE;
        } else {
            $this->error($evModel->getError());
            return FALSE;
        }
    }

    public function editEvent() {
        
    }

    public function addFee($repair_id) { //添加费用
        $fModel = M('fee');
        $fee['repair_id'] = $repair_id;
        if (!empty($_POST['artificial_fee'])) {
            $fee['fee_item'] = 0;
            $fee['price'] = $_POST['artificial_fee'];
            $fee['number'] = 1;
            $fee['repair_id_fee_item'] = $repair_id . $fee['fee_item'];
            $fModel->add($fee);
        }
        if (!empty($_POST['part_id'])) {
            foreach ($_POST['part_id'] as $k => $v) {
                $fee['fee_item'] = $v;
                $fee['price'] = $_POST['part_fee'][$k];
                $fee['number'] = $_POST['part_number'][$k];
                $fee['repair_id_fee_item'] = $repair_id . $fee['fee_item'];
                $fModel->add($fee);
            }
        }
    }

    public function getEvent($event_type, $repair_id) {//type=1（办理）的事件信息，event_value为预约维修人员ID;type=2（维修完）的事件信息，event_value为维修人员ID
        $evModel = M('event');
        $evData = $evModel->alias('a')                                      //获得事件类型为1或2的事件
                        ->field('a.*,b.real_name')
                        ->join('LEFT JOIN __USER__ b ON a.user_id=b.id')
                        ->where(array(
                            'repair_id' => $repair_id,
                            'event_type' => $event_type
                        ))->find();
        $evData['event_value'] = explode(',', $evData['event_value']);
        $evData['repair_user'] = array();
        $uModel = M('user');
        foreach ($evData['event_value'] as $k => $v) {
            $evData['repair_user'][] = $uModel->field('id,real_name')->find($v);
        }
        return $evData;
    }

    public function getFee($repair_id) {
        $fModel = M('fee');
        $fData = $fModel->where(array(
                    'repair_id' => $repair_id
                ))->select();
        $eqModel = M('part');
        foreach ($fData as $k => $v) {
            $fData[$k]['part'] = $eqModel->find($v['fee_item']);
        }
        return $fData; //返回费用信息以及所使用的配件信息
    }

    public function ajaxGetPart() {
        $part_id = I('get.part_id'); //字符串
        $part_id = explode(',', $part_id); //字符串转换为数组
        $paModel = M('part');
        $paData = $paModel->where(array(
                    'id' => array('in', $part_id),
                ))->select();
        echo json_encode($paData);
    }

}
