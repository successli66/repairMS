<?php

namespace Admin\Model;

use Think\Model;

class RepairModel extends Model {

    protected $insertFields = array('project_id', 'title', 'equipment_id', 'descr', 'report_person_id', 'company_id', 'address', 'contact', 'phone', 'appointment_time', 'repair_user_id', 'event_type', 'event_name', 'repair_id');
    protected $updateFields = array('id', 'project_id', 'title', 'equipment_id', 'descr', 'report_person_id', 'company_id', 'address', 'contact', 'phone', 'appointment_time', 'repair_user_id', 'event_type', 'event_name', 'repair_id');
    protected $_validate = array(
        array('title', 'require', '报修标题不能为空！', 1, 'regex', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('project_id', 'require', '问题类别不能为空！', 1, 'regex', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('equipment_id', 'check_equipment_id', '设备编号不能为空！', 1, 'callback', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('address', 'require', '维修地址不能为空！', 1, 'regex', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('contact', 'require', '联系人不能为空！', 1, 'regex', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('phone', 'require', '电话不能为空！', 1, 'regex', 1), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('appointment_time', 'require', '预约时间不能为空！', 1, 'regex', 2), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('repair_user_id', 'check_repair_user_id', '维修人员不能为空！', 1, 'callback', 2), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
    );

    protected function check_equipment_id($equipment_id) {
        if ($equipment_id > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function check_repair_user_id($repair_user_id) {
        if (empty($repair_user_id)) {
            return false;
        }
        return true;
    }

    public function search($pageSize = 15) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        $repair_status = I('get.repair_status');
        if ($repair_status) {
            if ($repair_status > 0) {
                $map['a.repair_status'] = $repair_status;
            }
        }
        $search_name = I('get.search_name');
        if ($search_name) {//模糊查询
            $where['a.title'] = array('like', "%$search_name%");
            $where['a.repair_order'] = array('like', "%$search_name%");
            $where['a.contact'] = array('like', "%$search_name%");
            $where['a.phone'] = array('like', "%$search_name%");
            $where['a.serial_number'] = array('like', "%$search_name%");
            $where['b.project_name'] = array('like', "%$search_name%");
            $where['c.real_name'] = array('like', "%$search_name%");
            $where['d.company_name'] = array('like', "%$search_name%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        /*         * *********************************** 翻页 *************************************** */
        $count = $this->alias('a')
                ->join('LEFT JOIN __PROJECT__ b ON a.project_id=b.id')
                ->join('LEFT JOIN __USER__ c ON a.report_person_id=c.id')
                ->join('LEFT JOIN __COMPANY__ d ON a.company_id=d.id')
                ->where($map)
                ->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->alias('a')->field('a.*,b.project_name,c.real_name,d.company_name')
                        ->join('LEFT JOIN __PROJECT__ b ON a.project_id=b.id')
                        ->join('LEFT JOIN __USER__ c ON a.report_person_id=c.id')
                        ->join('LEFT JOIN __COMPANY__ d ON a.company_id=d.id')
                        ->where($map)
                        ->order('a.id desc')
                        ->limit($page->firstRow . ',' . $page->listRows)->select();
//        foreach($data['data'] as $k=>&$v){                                      //循环每一条数据，拆分设备id，再次循环每个设备id，获得设备serial_number数据
//            $v['equipment_id'] = explode(',', $v['equipment_id']);
//            foreach ($v['equipment_id'] as $k1=>$v1){
//                $eqModel = M('Equipment');
//                $eqData = $eqModel->find($v1);
//                $v['serial_number'][] = $eqData['serial_number']; 
//            }
//            $v['serial_number'] = implode(',', $v['serial_number']);
//        }
        return $data;
    }

    protected function _before_insert(&$data, $options) {
        var_dump($data);
        die;
        $time = date('Y-m-d H:i:s', time());
        $order_time = date('YmdHis') . rand(10, 99);
        $company_id = session('company')['id'];
        $repair_order = $company_id . $order_time;
        $data['serial_number'] = array();
        foreach ($data['equipment_id'] as $k => $v) {
            $eqModel = M('Equipment');
            $eqData = $eqModel->find($v);
            $data['serial_number'][] = $eqData['serial_number'];
        }
        $data['serial_number'] = implode(',', $data['serial_number']);
        $data['equipment_id'] = implode(',', $data['equipment_id']);
        $data['report_time'] = $time;
        $data['repair_order'] = $repair_order;
        $data['repair_status'] = 1;
    }

    protected function _before_update(&$data, $options) {
        if (!empty($data['other_repair_user_id'])) {
            $data['repair_user_id'] = array_merge($data['repair_user_id'], $data['other_repair_user_id']); //合并数组
            $data['repair_user_id'] = array_unique($data['repair_user_id']);
        }
        $data['repair_user_id'] = implode(',', $data['repair_user_id']);
        $data['repair_status'] = 2;
        
    }

    public function findById($id) {
        $data = $this->alias('a')->field('a.*,b.project_name,c.real_name,d.company_name')
                        ->join('LEFT JOIN __PROJECT__ b ON a.project_id=b.id')
                        ->join('LEFT JOIN __USER__ c ON a.report_person_id=c.id')
                        ->join('LEFT JOIN __COMPANY__ d ON a.company_id=d.id')
                        ->where(array(
                            'a.id' => $id,
                        ))->find();
        return $data;
    }

}
