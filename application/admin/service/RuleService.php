<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/28 0028
 * Time: 11:56
 */

namespace app\admin\service;


class RuleService
{
    /**
     * 查询用户所拥有的权限
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function selectList($user_id)
    {
        $rules = db('auth_group_access a')
            ->where('uid',$user_id)
            ->join('auth_group b','a.group_id=b.group_id','LEFT')
            ->where('b.group_status',1)
            ->field('b.group_rules')
            ->select();
        //数据处理  整合
        $arr = [];
        foreach ($rules as $k => $v){
            $arr[] = $v['group_rules'];
        }
        //数组去重
        $rules = array_unique($arr);
        //查询具体规则 并无限极分类
        $rules = $this->createList($rules);

        return $rules;
    }

    /**
     * 构造权限列表的分级数据
     * @param $rules
     * @return array|string
     */
    protected function createList($rules)
    {
        $rules_str = implode(',',$rules);
        $data = db('auth_rule')
            ->where('rule_id in (' . $rules_str . ')')
            ->where(['rule_status'=>1,'rule_isshow'=>1])
            ->order('rule_sort')
            ->select();
        foreach ($data as $k => $v) {
            $data[$k]['rule_url'] = url($v['rule_url']);
        }
        //无限极分类
        $result = createTree($data, 0);
        return $result;
    }
    
}