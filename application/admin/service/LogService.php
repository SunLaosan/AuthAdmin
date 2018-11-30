<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/7/25 0025
 * Time: 09:49
 */

namespace app\admin\service;

use think\Request;

class LogService
{
    /**
     * 写入用户操作日志  数据库和文件同时存储
     * @param $content 内容
     * @param string $remarks 备注
     */
    static public function log($content, $remarks = '无')
    {
        $request = Request::instance();
        $ip = $request->ip();
        $name = session('user_name');
        if (!$name) $name = '未知用户';
        //记录数据库
        $data = [
            'log_name'  =>  $name,
            'log_ip'    =>  $ip,
            'log_content'=> $content,
            'log_remarks'=> $remarks
        ];
        $r = db('log')->insert($data);
        //记录文件 PHP_EOL为PHP匹配不同程序的换行符
        $string = "[ " . date('Y-m-d H:i:s') . " ] 用户:【" . $name . "】 操作:" . $content . " 操作IP:" . $ip . " 备注:" . $remarks . PHP_EOL;
        $file = config('user_log.file') . date('Ym') . '.txt';
        if (!file_exists($file)) {
            file_put_contents($file, $string, FILE_USE_INCLUDE_PATH);
        } else {
            file_put_contents($file, $string, FILE_APPEND | LOCK_EX);
        }

    }
}