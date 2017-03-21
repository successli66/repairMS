<?php

namespace Admin\Controller;

class RepairController extends BaseController{
    public function report(){
        $prModel = M('Project');
        $prData = $prModel->select();
        $this->assign('prData',$prData);
        $this->display();
    }
}

