<?php
namespace App\Demo\Controllers;

use Framework\App;
use App\Demo\Models\TestTable;
use Exception;

class ModelOperationDemo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * model example
     *
     * @return mixed
     */
    public function modelExample()
    {
        try {
            DB::beginTransaction();
            $testTableModel = new TestTable();

            // find one data
            $testTableModel->modelFindOneDemo();
            // find all data
            $testTableModel->modelFindAllDemo();
            // save data
            $testTableModel->modelSaveDemo();
            // delete data
            $testTableModel->modelDeleteDemo();
            // update data
            $testTableModel->modelUpdateDemo([
                   'nickname' => 'web-frame'
                ]);
            // count data
            $testTableModel->modelCountDemo();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return 'fail';
        }
    }
}
