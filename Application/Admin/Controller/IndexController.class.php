<?php

namespace Admin\Controller;

class IndexController extends BaseController {

    public function index() {
        $rpModel = M('repair');
        $newRepair = $rpModel->where(array(
                    'repair_status' => 1
                ))->order('report_time desc')
                ->select();
        $newRepairCount = $rpModel->where(array(
                    'repair_status' => 1
                ))->count();
        $repairing = $rpModel->where(array(
                    'repair_status' => 2
                ))->order('report_time desc')
                ->select();
        $repairingCount = $rpModel->where(array(
                    'repair_status' => 2
                ))->count();
        $repaired = $rpModel->where(array(
                    'repair_status' => 3
                ))->order('report_time desc')
                ->select();
        $repairedCount = $rpModel->where(array(
                    'repair_status' => 3
                ))->count();
        session('newRepairCount',$newRepairCount);
        session('repairingCount',$repairingCount);
        session('repairedCount',$repairedCount);
        $this->display();
    }

}
