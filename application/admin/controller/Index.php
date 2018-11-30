<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/21 0021
 * Time: 14:40
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Config;
use app\admin\model\AuthRule;
use app\admin\service\CommonService;
use app\admin\service\RuleService;

class Index extends Base
{
    protected $beforeActionList = [
        'selectConfig'  =>  ['only' =>  'index']
    ];

    public function index()
    {
        //通过权限判断展示列表
        $user_id = session('user_id');
        $obj = new RuleService();
        $list = $obj->selectList($user_id);

        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 欢迎页
     * @return mixed
     */
    public function welcome()
    {
        //查询管理员基本信息  服务器信息
        $admin = CommonService::valueFind('admin', ['admin_id'=>session('user_id')]);

        $info = array(
            //操作系统
            'czxt'=>PHP_OS,
            //运行环境
            'yxhj'=>$_SERVER["SERVER_SOFTWARE"],
            //主机名
            'zjm'=>$_SERVER['SERVER_NAME'],
            //服务端口
            'fwdk'=>$_SERVER['SERVER_PORT'],
            //网站文档目录
            'wzwdml'=>$_SERVER["DOCUMENT_ROOT"],
            //游览器信息
            'ylqxx'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            //通信协议
            'txxy'=>$_SERVER['SERVER_PROTOCOL'],
            //请求方法
            'qqff'=>$_SERVER['REQUEST_METHOD'],
            //tp版本
            'bb'=>THINK_VERSION,
            //上传附件限制
            'scfjxz'=>ini_get('upload_max_filesize'),
            //执行时间限制
            'zxsjxz'=>ini_get('max_execution_time').'秒',
            //服务器时间
            'fwqsj'=>date("Y年n月j日 H:i:s"),
            //北京时间 以格林尼治时间转东八区时间为准 其实和设置时区为中国是一样的
            'bjsj'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            //服务器域名 服务器IP
            'fwqym'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            //用户的IP地址
            'yhdipdz'=>$_SERVER['REMOTE_ADDR'],
            //剩余空间
            'sykj'=>round((disk_free_space(".")/(1024*1024)),2).'M',
        );

        $this->assign('admin',$admin);
        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
     * 查询网站名称
     */
    protected function selectConfig()
    {
        $obj = new Config();
        $web_name = $obj->webName();
        $this->assign('web_name',$web_name);
    }
}