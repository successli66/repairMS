<?php

namespace Admin\Model;
use Think\Model;

class ProjectModel extends Model{
    protected $insertFields = array('project_name', 'department_id', 'team', 'descr','phone');
    protected $updateFields = array('id', 'project_name', 'department_id', 'team', 'descr','phone');
    protected $_validate = array(
        array('project_name', 'require', '项目名称不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('project_name','','项目名称不能重复',1,'unique',1),
        array('department_id', 'require', '所属部门不能为空！', 1, 'regex', 3),
        array('team', 'check_select', '维修团队不能为空！',1, 'callback'),
    );
    
    protected function check_select($team){//验证是否选择团队
        if(empty($team)){
            return false;
        }
        return true;
    }

    public function search($pageSize = 2) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        if ($search_name = I('get.search_name'))
            $where['project_name'] = array('like', "%$search_name%");
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}

