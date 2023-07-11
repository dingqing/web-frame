<?php
namespace App\Demo\Controllers;

class Demo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * api
     *
     * @example domain/demo/demo/get
     */
    public function get()
    {
        $data = [
            'content' => 'Hello web-frame!'
        ];
        $data = array_fill(0, 20, $data);
        return $data;
    }
}
