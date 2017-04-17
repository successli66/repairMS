<?php

namespace Admin\Model;
use Think\Model;

class RepairModel extends Model{
    protected $insertFields = array('project_id', 'title','equipment_id', 'descr', 'report_person','address','contact','phone');
    protected $updateFields = array('id', 'project_id', 'title','equipment_id', 'descr', 'report_person','address','contact','phone');
    protected $_validate = array(
        array('title', 'require', '报修标题不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('project_id', 'require', '问题类别不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('equipment_id', 'check_equipment_id', '设备编号不能为空！', 1, 'callback'),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('address', 'require', '维修地址不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('contact', 'require', '联系人不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('phone', 'require', '电话不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
    );
    
    protected function check_equipment_id($equipment_id){
        if($equipment_id > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function search($pageSize = 15) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        $repair_status = I('get.repair_status');
        if($repair_status){
            $map['repair_status'] = $repair_status;
        }
        $search_name = I('get.search_name');
        if($search_name){//模糊查询
            $where['title'] = array('like',"%$search_name%");
            $where['equipment_id'] = array('like',"%$search_name%");
            $where['repair_order'] = array('like',"%$search_name%");
            $where['address'] = array('like',"%$search_name%");
            $where['contact'] = array('like',"%$search_name%");
            $where['phone'] = array('like',"%$search_name%");
            $where['b.project_name'] = array('like',"%$search_name%");
            $where['c.real_name'] = array('like',"%$search_name%");
            $where['d.company_name'] = array('like',"%$search_name%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($map)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->alias('a')->field('a.*,b.id as project_id,b.project_name,c.id as user_id,d.id as company_id,d.company_name')
                ->join('LEFT JOIN __PROJECT__ b ON a.project_id=b.id')
                ->join('LEFT JOIN __USER__ c ON a.report_persion_id=c.id')
                ->join('LEFT JOIN __COMPANY__ d ON a.company_id=d.id')
                ->where($map)
                ->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
    
    protected function _before_insert(&$data, $options) {
        $time = date('Y-m-d H:i:s',time());
        $order_time = date('YmdHis') . rand(0,99);
        $company_id = session('company')['id'];
        $report_order = $company_id . $order_time;
        $data['time'] = $time;
        $data['report_order'] = $report_order;
        $data['repair_status'] = 0;
    }
}

