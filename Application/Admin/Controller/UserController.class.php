<?php

namespace Admin\Controller;

class UserController extends BaseController{
    public function userInfo(){
        $model = M();
        $this->display();
    }
}

