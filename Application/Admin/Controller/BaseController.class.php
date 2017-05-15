<?php

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller {

    public function __construct() {
        parent::__construct();
        if (!session('user')['id']) {
            $this->error('您还未登录，请先登录！', U('Login/login'));
        }
        if (CONTROLLER_NAME == 'Index') {
            return TRUE;
        }
        $priModel = D('privilege');
        if (!$priModel->checkPrivilege()) {
            $this->error('您无权访问！');
        }
    }

}
