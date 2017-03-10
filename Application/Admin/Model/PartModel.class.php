<?php

namespace Admin\Model;
use Think\Model;

class PartModel extends Model{
    protected $insertFields = array('project_id', 'part_name', 'model', 'manufacturer','in_price','out_price','descr');
    protected $updateFields = array('id', 'part_name', 'model', 'manufacturer','in_price','out_price','descr');
    protected $_validate = array(
        array('part_name', 'require', '配件名称不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
        array('part_name','','配件名称不能重复',1,'unique',1),
        array('model', 'require', '型号不能为空！', 1, 'regex', 3),//1表示不管字段存不存在都验证，3表示新增、编辑都验证
    );

    public function search($pageSize = 15) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        $search_name = I('get.search_name');
        $map['project_id'] = I('get.project_id');
        if($search_name){//模糊查询
            $where['part_name'] = array('like',"%$search_name%");
            $where['model'] = array('like',"%$search_name%");
            $where['manufacturer'] = array('like',"%$search_name%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($map)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}

