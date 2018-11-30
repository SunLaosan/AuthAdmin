<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2017/12/8 0008
 * Time: 下午 3:43
 */

namespace app\admin\controller;

use app\admin\service\CommonService;
use app\admin\service\AdminService;
use app\admin\controller\Base;
use app\admin\service\LogService;

class Admin extends Base
{
    //管理员列表
    public function adminShow()
    {
        $r=AdminService::selectAdmin();
        $this->assign('content',$r);
        return $this->fetch();
    }
    //修改管理员展示信息
    public function adminUpdate()
    {
        $admin_id=input('id');
        if(!$admin_id)
        {
            return $this->error('未知分类',url('admin/adminshow'));
        }
        $r=AdminService::selectUpdate($admin_id);
        $this->assign('content',$r);
        return $this->fetch();
    }
    //修改管理员处理
    public function adminUpdateDo()
    {
        $admin_name=input('post.name');
        $admin_pwd=input('post.pwd');
        $admin_id=input('post.id');

        if(!$admin_id)
        {
            return CommonService::returnData(0,'未知数据');
        }
        if(!$admin_name)
        {
            return CommonService::returnData(0,'账号不能为空');
        }
        //判断重复
        $repeat=CommonService::checkRepeat('admin',['admin_name'=>$admin_name,'admin_status'=>1],'admin_id !='.$admin_id);
        if($repeat)
        {
            return CommonService::returnData(0,'该账号已存在');
        }
        $data=[
            'admin_name'    =>  $admin_name,
        ];
        if($admin_pwd)
        {
            $data['admin_pwd']=md5($admin_pwd);
        }
        $r=AdminService::updateAdmin($admin_id,$data);
        if($r)
        {
            LogService::log('修改管理员成功', '管理员ID:' . $admin_id);
            return CommonService::returnData(1,'修改成功');
        }else{
            return CommonService::returnData(0,'修改失败或没有修改项');
        }
    }
    //删除管理员
    public function adminDelete()
    {
        $id=input('post.id');
        if(!$id)
        {
            return CommonService::returnData(0,'未知数据');
        }
        $r=AdminService::deleteAdmin($id);
        if($r)
        {
            LogService::log('删除管理员成功', '管理员ID:' . $id);
            return CommonService::returnData(1,'删除成功');
        }else{
            return CommonService::returnData(0,'删除失败');
        }
    }
    //添加管理员
    public function adminAdd()
    {
        return $this->fetch();
    }
    //添加管理员处理
    public function adminAddDo()
    {
        $admin_name=input('post.name');
        $admin_pwd=input('post.pwd');
        if(!$admin_name)
        {
            return CommonService::returnData(0,'管理员账号不能为空');
        }
        //判断重复
        $repeat=CommonService::checkRepeat('admin',['admin_name'=>$admin_name,'admin_status'=>1]);
        if($repeat)
        {
            return CommonService::returnData(0,'该账号已存在');
        }
        if(!$admin_pwd)
        {
            return CommonService::returnData(0,'密码不能为空');
        }
        $data=[
            'admin_name'    =>  $admin_name,
            'admin_pwd'     =>  md5($admin_pwd),
        ];
        $r=AdminService::insertAdmin($data);
        if($r)
        {
            LogService::log('添加管理员成功', '管理员ID:' . $r);
            return CommonService::returnData(1,'添加成功');
        }else{
            return CommonService::returnData(0,'添加失败');
        }
    }
}