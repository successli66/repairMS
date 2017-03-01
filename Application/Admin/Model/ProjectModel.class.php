<?php

namespace Admin\Model;
use Think\Model;

class ProjectModel extends Model{
    protected $insertFields = array('project_name', 'department_id', 'team', 'descr ');
    protected $updateFields = array('id', 'project_name', 'department_id', 'team', 'descr ');
    protected $_validate = array(
        array('project_name', 'require', '项目名称不能为空！', 1, 'regex', 3),
        array('project_name','','项目名称不能重复',1,'unique',3),
        array('department_id', 'require', '所属部门不能为空！', 1, 'regex', 3),
        array('team', 'require', '维修团队不能为空！', 1, 'regex', 3),
    );

    public function search($pageSize = 3) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        if ($search_name = I('get.search_name'))
            $where['project_name'] = array('like', "%$search_name%");
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this ->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}

