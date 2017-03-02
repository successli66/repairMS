<?php

namespace Admin\Model;

use Think\Model;

class UserModel extends Model {

    protected $insertFields = array('username', 'pw', 'rpw', 'real_name', 'work_number', 'telephone', 'company_id', 'department_id', 'verify');
    protected $updateFields = array('id', 'username', 'pw','rpw', 'real_name', 'work_number', 'telephone', 'company_id', 'department_id');
    //为登录表单定义一个验证规则
    public $_validate = array(
        array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
        array('username', '', '用户名已存在！', 1, 'unique', 3),
        array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('real_name', 'require', '员工姓名不能为空！', 1, 'regex', 3),
        array('department_id', 'require', '必须选择所属部门！', 1, 'regex', 3),
    );
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('pw', 'require', '密码不能为空！', 1),
        array('verify', 'require', '验证码不能为空！', 1),
        array('verify', 'check_vercode', '验证码错误！', 1, 'callback'),
    );
    
    public $_editPw_validate = array(
        array('pw', 'require', '密码不能为空！', 1, 'regex', 3),
        array('pw', '6,32', '密码长度为6到32个字符！', 1, 'length', 3),
        array('rpw', 'pw', '两次输入的密码不一致！', 1, 'confirm', 3),
    );

    //验证验证码是否正确
    function check_vercode($code, $id = '') {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    //用户登录
    public function login() {
        $username = $this->username;
        $pw = $this->pw;
        $user = $this->where(array(
                    'username' => $username,
                ))->find();
        if ($user) {
            if (md5($pw) == $user['pw']) {
                //登录成功，保存session
                session('user', $user);
                $cpModel = M('Company');
                $company = $cpModel->find($user['company_id']);
                session('company', $company);
                $dpModel = M('Department');
                $department = $dpModel->find($user['department_id']);
                session('department', $department);
                return true;
            } else {
                $this->error = '用户名或密码错误！';
                return false;
            }
        } else {
            $this->error = '用户名或密码错误！';
            return false;
        }
    }

    //用户注销
    public function logout() {
        session(null);
    }

    public function getUserByDep() {
        $uData = $this->where(array(
                    'department_id' => session('department')['id']
                ))->select();
        return $uData;
    }

    public function search($pageSize = 2) {
        $map = array();
        $company_id = I('get.company_id');
        if ($company_id) {
            $map['a.company_id'] = array('eq', $company_id);
        }
        $department_id = I('get.department_id');
        if ($department_id) {
            $map['a.department_id'] = array('eq', $department_id);
        }
        $search_name = I('get.search_name');
        if($search_name){//模糊查询
            $where['a.username'] = array('like',"%$search_name%");
            $where['a.real_name'] = array('like',"%$search_name%");
            $where['a.work_number'] = array('like',"%$search_name%");
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }
        $count = $this->alias('a')->where($map)->count();
        $page = getpage($count, $pageSize);
        $data['page'] = $page->show();
        $data['data'] = $this->alias('a')->field('a.*,b.company_name,c.department_name')
                ->join('LEFT JOIN __COMPANY__ b ON a.company_id=b.id')
                ->join('LEFT JOIN __DEPARTMENT__ c ON a.department_id=c.id')
                ->where($map)
                ->group('a.id')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
        return $data;
    }

    //添加用户前密码加密
    protected function _before_insert(&$data, $option) {
        $data['pw'] = md5($data['pw']);
    }

}
