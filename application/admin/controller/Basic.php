<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/28 0028
 * Time: 14:37
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Config;
use app\admin\service\LogService;
use app\admin\service\CommonService;

class Basic extends Base
{
    /**
     * 修改的展示
     * @return mixed
     */
    public function index()
    {
        $obj = new Config();
        $result = $obj->selectShow();

        $this->assign('list',$result);
        return $this->fetch();
    }

    /**
     * 修改处理
     * @return \think\response\Json
     */
    public function configUpdateDo()
    {
        $web_name = input('web_name');
        $web_phone = input('web_phone');
        $web_address = input('web_address');
        $web_email = input('web_email');
        $web_icp = input('web_icp');
        $web_gongan = input('web_gongan');
        $web_ico = input('web_ico');

        if (!$web_name) return CommonService::returnData(0,'系统名不能为空');

        $data = [
            'web_name'     =>  $web_name,
            'web_phone'    =>  $web_phone,
            'web_address'  =>  $web_address,
            'web_email'    =>  $web_email,
            'web_icp'      =>  $web_icp,
            'web_gongan'   =>  $web_gongan,
            'web_ico'      =>  $web_ico
        ];
        $r = CommonService::valueUpdate('web_config', ['web_id'=>1], $data);
        return CommonService::returnJudge($r, '修改网站基本信息');
    }
}