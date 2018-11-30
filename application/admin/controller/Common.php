<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/7/4 0004
 * Time: 13:27
 */

namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
    /**
     * fileupload插件后台处理方法
     * @param string $name
     * @return \think\response\Json
     */
    public function fileupload($name = 'img')
    {
        $url = $this->upload($name);
        if ($url) return CommonService::returnData(1,$url);
        return CommonService::returnData(0,'上传失败');
    }

    /**
     * webuploader插件
     * @return \think\response\Json
     */
    public function webuploader()
    {
        $r = $this->upload("file");
        $data['url']=$r;
        return json($data);
    }
}