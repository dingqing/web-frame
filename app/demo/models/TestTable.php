<?php
namespace App\Demo\Models;

use Framework\App;
use Framework\Orm\Model;
use Framework\Exceptions\CoreHttpException;

class TestTable extends Model
{
    /**
     * sql 操作示例
     *
     * find
     *
     * @return void
     */
    public function modelFindOneDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $res = $this->where($where)
                    ->orderBy('id asc')
                    ->findOne();
        $sql = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * findAll
     *
     * @return void
     */
    public function modelFindAllDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $res      = $this->where($where)
                             ->orderBy('id asc')
                             ->limit(5)
                             ->findAll(['id','create_at']);
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Insert
     *
     * @return void
     */
    public function modelSaveDemo()
    {
        $data = [
            'nickname' => 'web-frame',
        ];
        $res      = $this->save($data);
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Delete
     *
     * @return void
     */
    public function modelDeleteDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $res      = $this->where($where)
                             ->delete();
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Update
     *
     * @return void
     */
    public function modelUpdateDemo($data = [])
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $res      = $this->where($where)
                         ->update($data);
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Count
     *
     * @return void
     */
    public function modelCountDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $res      = $this->where($where)
                         ->count('id as CountId');
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Sum
     *
     * @return void
     */
    public function modelSumDemo()
    {
        $where = [
            'id'   => ['>=', 1],
        ];
        $res      = $this->where($where)
                             ->sum('id as SumId');
        $sql      = $this->sql;

        return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * query
     *
     * @return void
     */
    public function modelQueryDemo()
    {
        $res      = $this->query('SELECT `id` as `SumId` FROM `user` WHERE `id` >= 1');
        $sql      = $this->sql;

        // return $sql;
        return $res;
    }
}
