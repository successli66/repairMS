<?php

namespace Admin\Model;

use Think\Model;

class DepartmentModel extends Model {
    protected $insertFilds = array('department_name','header','business','phone','company_id');
    protected $updataFilds = array('id','department_name','header','business','phone','company_id');
    protected $_varlidate = array(
        array('department_name','require','部门名称不能为空',1,'regex',3),
        array('header','require','部门负责人不能为空',1,'regex',3),
        array('company_id','require','必须选择所属公司',1,'regex',3),
    );
    
    public function search(){
        $where = array();
        if($search_name = I('get.search_name')){
            $where['department_name'] = array('like','%search_name%');
        }
        if($company_id = I('get.company_id')){
            $where['company_id'] = array('eq',$company_id);
        }
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        $data['data'] = $this ->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}

