<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/25 0025
 * Time: 14:01
 */

namespace app\admin\controller;

use app\admin\service\CommonService;
use app\admin\service\LoginService;
use think\Controller;
use think\Cookie;
use think\Session;
use app\admin\model\Config;
use app\admin\model\Admin;
use app\admin\service\LogService;

class Login extends Controller
{
    //前置操作方法 查询网站名称
    protected $beforeActionList = [
        'selectWebName' =>  ['only' => 'login']
    ];

    /**
     * 渲染后台登录界面
     * @return mixed
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 登录验证
     * @return mixed
     */
    public function checkLogin()
    {
        $admin = input('admin_name');
        $pwd = input('admin_pwd');
        $obj = new Admin();
        $result = $obj->loginCheck($admin, $pwd);
        //判断
        if ($result) {
            if ($result->admin_status == 1){
                //存储session
                session('user_id',$result->admin_id);
                session('user_name',$result->admin_name);
                //数据库操作
                $data = [
                    'admin_lasttime'    =>  date('Y-m-d H:i:s'),
                    'admin_ip'          =>  $_SERVER["REMOTE_ADDR"],
                    'admin_times'       =>  ['exp','admin_times+1']
                ];
                CommonService::valueUpdate('admin', ['admin_id'=>$result->admin_id], $data);
                LogService::log('登陆成功');
                return $this->returnJson(1,'登录成功');
            } else {
                LogService::log('被禁止用户尝试登陆', '使用账号:' . $admin);
                return $this->returnJson(0,'此账号已被限制登录');
            }
        } else {
            LogService::log('登陆失败', '使用账号:' . $admin . '密码:' . $pwd);
            return $this->returnJson(0,'账号或密码不正确');
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        LogService::log('退出登录');
        //清空session
        Session::clear();
        if (Cookie::has('user_id')) {
            //清空cookie
            Cookie::clear();
        }
        return $this->redirect('login/login');
    }

    /**
     * 前置操作 查询网站名
     */
    protected function selectWebName()
    {
        $obj = new Config();
        $web_name = $obj->webName();
        $this->assign('web_name',$web_name);
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
}