<?php

namespace Admin\Controller;

class CompanyController extends BaseController {
    
    public function companyList(){
        $model = D('Company');
        $data = $model->search();
        $this->assign(array(
            'data'=>$data['data'],
            'page'=>$data['page'],
            'page_count'=>$data['page_count']
        ));
        $this->display();
    }
    
    public function add(){
        if(IS_POST){
            $model = D('Company');
            if($model->create(I('post.'),1)){
                if($id = $model->add()){
                    $this->success('添加成功！',U('companyList'),1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }
    
}

