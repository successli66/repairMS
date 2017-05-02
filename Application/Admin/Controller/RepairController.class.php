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
            $evModel = M('event');
            $startData = $evModel->where(array(                                  //获得事件类型为1（接报）且维修单号为$id的事件信息
                        'repair_id' => $id,
                        'event_type' => 1,
                    ))->find();
            $evData = $evModel->alias('a')                                      //获得事件类型为1或2的事件
                            ->field('a.*,b.real_name')
                            ->join('LEFT JOIN __USER__ b ON a.user_id=b.id')    //获得处理人的信息
                            ->where(array(
                                'a.repair_id' => $id,
                                'a.event_type' => array('in', [1, 2]),
                            ))->order('event_time asc')->select();
            foreach ($evData as $k => &$v) {
                if ($v['event_type'] == 1) {                                    //事件类型为1（接报），event_value中存储预约维修人员ID的字符串
                    $uId = explode(',', $v['event_value']);
                    foreach ($uId as $k1 => $v1) {                              //循环每个iD获得维修人员信息
                        $uModel = M('User');
                        $uData = $uModel->find($v1);
                        $v['repair_user'][] = $uData;
                    }
                }
                if ($v['event_type'] == 2) {                                    //预留功能，待完善，查询出每个修改记录
                    $modId = explode(',', $v['event_value']);
                    foreach ($modId as $k1 => $v1) {
                        $modModel = M('modify');
                        $modData = $modModel->find($v1);
                        $v['modify'][] = $modData;
                    }
                }
            }
        }
        if ($data['repair_status'] == 3) {
            $data['next'] = 'end';
        }
        $this->assign(array(
            'data' => $data,
            'startData' => $startData,
            'evData' => $evData, //三维数组
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
                }
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
            $this->error($evModel->getError());
            return FALSE;
        }
    }
    
    public function repaired(){
        var_dump($_POST);
        $project_id = I('project_id');
        $paModel = M('part');
        $paData = $paModel->where(array(
            'project_id'=>$project_id,
        ))->select();
        $this->assign('paData',$paData);
        $this->display();
    }

    public function ajaxGetPart(){
        $part_id = I('post.part_id');//字符串
        //$part_id = explode(',', $part_id);//字符串转换为数组
        $paModel = M('part');
        $paData = $paModel->where(array(
            'part_id'=>array('in',$part_id),
        ))->select();
        echo json_encode($paData);
    }
}
