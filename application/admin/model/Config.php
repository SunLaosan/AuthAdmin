<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/26 0026
 * Time: 13:49
 */

namespace app\admin\model;

use think\Model;

class Config extends Model
{
    //设置主键名
    protected $pk = 'config_id';

    /**
     * 查询网站名称
     * @return mixed
     */
    public function webName()
    {
        $web_name = self::where('config_id',1)->value('config_webname');
        return $web_name;
    }

    /**
     * 查询目前的网站配置
     * @return null|static
     */
    public function selectShow()
    {
        $result = self::get(1);
        return $result;
    }
}