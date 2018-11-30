<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/26 0026
 * Time: 16:30
 */

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    protected $pk = 'admin_id';

    /**
     * 检查登录  数据库操作
     * @param $name
     * @param $pwd
     * @return null|static
     */
    public function loginCheck($name, $pwd)
    {
        $result = Admin::get(['admin_name'=>$name,'admin_pwd'=>md5($pwd)]);
        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @return false|int
     */
    public function insertLogin($id, $data)
    {
        $result = $this->save($data, ['admin_id'=>$id]);
        return $result;
    }
}