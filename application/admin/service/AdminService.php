<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2017/12/8 0008
 * Time: 下午 3:43
 */

namespace app\admin\service;

use think\Db;
class AdminService
{
    /*查询管理员
     * @return obj
     * */
    static function selectAdmin()
    {
        $r=db('admin')->where('admin_status',1)
            ->field('admin_id,admin_name,admin_ctime,admin_times,admin_ip,admin_lasttime')
            ->paginate(10);
        return $r;
    }
    /*修改用信息
     * @param   admin_id
     * @return  array
     * */
    static function selectUpdate($admin_id)
    {
        $r=db('admin')->where('admin_id',$admin_id)->field('admin_id,admin_name')
            ->find();

        return $r;
    }
    /*修改管理员信息
     * @param   admin_id
     * @param   data
     * @return  bool
     * */
    static function updateAdmin($admin_id,$data)
    {
        $r=db('admin')->where('admin_id',$admin_id)->update($data);
        return $r;
    }
    /*删除管理员 单条删除 批量删除
     * @param   id
     * @return  bool
     * */
    static function deleteAdmin($id)
    {
        $r=db('admin')->where('admin_id in ('.$id.')')->update(['admin_status'=>0]);
        return $r;
    }
    /*添加管理员
     * @param   data
     * @param   role    权限字符串
     * @return  bool
     * */
    static function insertAdmin($data)
    {
        $r=db('admin')->insertGetId($data);
        return $r;
    }
}