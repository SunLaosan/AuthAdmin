<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/21 0021
 * Time: 14:40
 */

namespace app\admin\controller;

use think\Controller;
use think\Loader;
use think\Session;
use think\Cookie;
use app\admin\service\CommonService;

class Base extends Controller
{
    protected $current_action;

    public function _initialize()
    {
        //检查登录态
        $user_id = $this->checkLogin();
        if ($user_id === false) {
            //未登录状态 跳转到登录页
            return $this->redirect('admin/login/login');//此处为了和路由地址相对应,模块/控制器/方法
        }

        //检查权限
        $auth = $this->checkRules($user_id);
        if ($auth === false){
            //权限验证失败
            //return alert('没有权限!',url('admin/index/index'));
            return $this->error('没有权限');
        }

        //查询基本信息参数显示 头部信息
        $title = CommonService::selectTitle($this->current_action);
        $this->assign('title',$title);
    }

    /**
     * 上传文件处理方法
     * @param string $name  表单里file的name属性
     * @return bool|mixed|string
     */
    public function upload($name = 'img')
    {
        // 获取表单上传文件
        $file = request()->file($name);

        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                $url = $info->getSaveName();
                //将\转换为/
                $url=str_replace("\\","/",$url);
                return $url;
            } else {
                // 上传失败获取错误信息
                return false;
            }
        }
        return false;
    }

    /**
     * 检查登录
     * @return bool|mixed
     */
    public function checkLogin()
    {
        if (session::has('user_id')) {
            $user_id = session('user_id');
            return $user_id;
        } elseif (cookie::has('user_id')) {
            $user_id = cookie('user_id');
            //设置session
            session::set('user_id',cookie('user_id'));
            session::set('user_name',cookie('user_name'));
            return $user_id;
        }
        return false;
    }

    /**
     * 权限验证
     * @param $user_id
     * @return bool
     */
    public function checkRules($user_id)
    {
        Loader::import("org/Auth", EXTEND_PATH);
        $auth=new \Auth();
        $this->current_action = request()->module().'/'.request()->controller().'/'.lcfirst(request()->action());
        $result = $auth->check($this->current_action,$user_id);
        if($result){
            return true;
        }
        return false;
    }

    /**
     * 返回json数据
     * @param $code
     * @param $msg
     * @return \think\response\Json
     */
    public function returnJson($code, $msg)
    {
        $arr = [
            'code'  =>  $code,
            'msg'   =>  $msg
        ];
        return json($arr);
    }
    /**
     * 空控制器
     */
    public function _empty()
    {
        echo '未找到控制器';
    }
}