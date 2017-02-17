<?php

namespace Admin\Model;

use Think\Model;

class CompanyModel extends Model {

    protected $insertFields = array('company_name', 'business', 'address', 'phone');
    protected $updateFields = array('id', 'company_name', 'business', 'address', 'phone');
    protected $_validate = array(
        array('company_name', 'require', '公司名称不能为空！', 1, 'regex', 3),
        array('address', 'require', '公司地址不能为空！', 1, 'regex', 3),
    );

    public function search($pageSize = 1) {
        /*         * ************************************** 搜索 *************************************** */
        $where = array();
        if ($search_name = I('get.search_name'))
            $where['company_name'] = array('like', "%$search_name%");
        /*         * *********************************** 翻页 *************************************** */
        $count = $this->where($where)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        /*         * ************************************ 取数据 ***************************************** */
        $data['data'] = $this ->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }

}
