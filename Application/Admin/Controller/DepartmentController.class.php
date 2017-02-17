<?php

namespace Admin\Controller;

/**
 * Description of DepartmentController
 *
 * @author LI
 */
class DepartmentController extends BaseController{
    
    public function departmentList() {
        $model = D('department');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->display();
    }
}
