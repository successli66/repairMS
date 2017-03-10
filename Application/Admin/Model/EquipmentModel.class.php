<?php

namespace Admin\Model;
use Think\Model;

class EquipmentModel extends Model{
    protected $insertFields = array('project_id', 'equipment_name','manufacturer', 'model', 'serial_number','install_date','address','descr');
    protected $updateFields = array('id', 'equipment_name','manufacturer', 'model', 'serial_number','install_date','address','descr');
    protected $_validate = array(
        array('equipment_name', 'require', '配件名称不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('model', 'require', '型号不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('serial_number', 'require', '设备编号不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('serial_number','','设备编号不能重复',1,'unique',1),
    );

    public function search($pageSize = 15) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        $company_id = I('get.company_id');
        if($company_id){
            $map['company_id'] = $company_id;
        }
        $search_name = I('get.search_name');
        $map['project_id'] = I('get.project_id');
        if($search_name){//模糊查询
            $where['equipment_name'] = array('like',"%$search_name%");
            $where['model'] = array('like',"%$search_name%");
            $where['manufacturer'] = array('like',"%$search_name%");
            $where['serial_number'] = array('like',"%$search_name%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($map)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->alias('a')->field('a.*,b.id as company_id,b.company_name')
                ->join('LEFT JOIN __COMPANY__ b ON a.company_id=b.id')
                ->where($map)
                ->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}

