<?php

namespace Admin\Model;

use Think\Model;

class DepartmentModel extends Model {

    protected $insertFields = array('department_name', 'header', 'business', 'phone', 'company_id');
    protected $updateFields = array('id', 'department_name', 'header', 'business', 'phone', 'company_id');
    protected $_validate = array(
        array('department_name', 'require', '部门名称不能为空', 1, 'regex', 3),
        array('department_name', '', '部门名称不能重复', 1, 'unique', 3),
    );

    public function search($pageSize = 2) {
        $where = array();
        if ($search_name = I('get.search_name')) {
            $where['department_name'] = array('like', "%$search_name%");
        }
        if ($company_id = I('get.company_id')) {
            $where['company_id'] = array('eq', $company_id);
        }
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        $data['data'] = $this->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }

    public function getDpByCpId($company_id) {
        $where['company_id'] = $company_id;
        $dpData = $this->where($where)->select();
        return $dpData;
    }
    
    

}
