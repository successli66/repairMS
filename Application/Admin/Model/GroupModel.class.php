<?php

namespace Admin\Model;

use Think\Model;

class GroupModel extends Model {

    protected $insertFields = array('superior_id', 'group_name');
    protected $updateFields = array('id', 'superior_id', 'group_name');
    protected $_validate = array(
        array('group_name', 'require', '分组名称不能为空！', 1, 'regex', 3),
        array('group_name', '', '分组名称不能重复', 1, 'unique', 3),
        array('superior_id', 'check_superior_id', '上级组不能为空！', 1, 'callback', 3), //1表示不管字段存不存在都验证，3表示新增、编辑都验证
    );

    protected function check_superior_id($equipment_id) {
        if ($equipment_id >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function search($pageSize = 3) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        if ($search_name = I('get.search_name'))
            $where['company_name'] = array('like', "%$search_name%");
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }

    public function get_tree() {
        $data = $this->select();
        return $this->_getTree($data);
    }

    //递归排序
    public function _getTree($data, $parent_id = 0, $level = 0) {
        static $_ret = array();
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level;
                $_ret[] = $v;
                $this->_getTree($data, $v['id'], $level + 1);
            }
        }
        return $_ret;
    }

}
