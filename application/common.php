<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * $msg 待提示的消息
 * $url 待跳转的链接
 * $icon 这里主要有两个，5和6，代表两种表情（哭和笑）
 * $time 弹出维持时间（单位秒）
 */
    function alert($msg='',$url='',$icon='',$time=3)
    {
        $str='<script type="text/javascript" src="__ADMIN__lib/jquery/1.9.1/jquery.min.js"></script>';
        $str.='<script type="text/javascript" src="__ADMIN__lib/layer/2.4/layer.js"></script>';//加载jquery和layer
        $str.='<script>$(function(){layer.msg("'.$msg.'",{icon:'.$icon.',time:'.($time*1000).'});setTimeout(function(){self.location.href="'.$url.'"},2000)});</script>';//主要方法
        return $str;
    }

/**
 * 无限极分类 会过滤掉没有父级且自身不是一级的数据
 * @param $data 数据
 * @param $pid  顶级数据pid
 * @param string $pid_key   父ID标识的字段名
 * @param string $pk       主键字段名
 * @return array|string
 */
    function createTree($data, $pid, $son = 'son', $pid_key = 'rule_pid', $pk = 'rule_id')
    {
        $tree = '';
        foreach($data as $k => $v)
        {
            if($v[$pid_key] == $pid)
            {   //父亲找到儿子
                $son_data = createTree($data, $v[$pk]);
                $type = gettype($son_data);
                if ($type == 'string') {
                    $v[$son] = [];
                } else {
                    $v[$son] = $son_data;
                }

                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }