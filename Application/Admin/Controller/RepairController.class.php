<?php

namespace Admin\Controller;

class RepairController extends BaseController{
    public function report(){
        if(IS_POST){
            var_dump($_POST) ;
            $model = D('Repair');
            if($model->create(I('post.'),1)){
                if($model->add()){
                    $this->success('提交成功！',U('reportList'),1);
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $prModel = M('Project');
        $prData = $prModel->select();
        $this->assign('prData',$prData);
        $this->display();
    }
}

