<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/29 0029
 * Time: 13:34
 */

namespace app\admin\service;

use app\admin\service\CommonService;

class RoleService
{
    /**
     * 查询所有权限组
     * @return \think\Paginator
     */
    static public function selectGroup()
    {
        $r = db('auth_group')
            ->where('group_status',1)
            ->paginate(10);

        return $r;
    }

    /**
     * 查询所有权限规则
     * @return $this
     */
    static public function selectRule()
    {
        $r = db('auth_rule')
            ->where('rule_status',1)
            ->order('rule_sort')
            ->select();

        $date = createTree($r, 0);
        return $date;
    }

    /**
     * 查询当前权限组权限及所有权限
     * @param $id
     * @return array
     */
    static public function selectNode($id)
    {
        $r = db('auth_group')->where('group_id',$id)->value('group_rules');
        $ids = trim($r,'');

        $rule_arr = explode(',',$ids);
        $rules = self::createList($rule_arr);
        return $rules;
    }

    /**
     * 构造权限列表的分级数据
     * @param $rules
     * @return array|string
     */
    static protected function createList($rule_arr)
    {
        $data = db('auth_rule')
            ->where(['rule_status'=>1])
            ->order('rule_sort')
            ->select();
        //dump($rule_arr);
        foreach ($data as $k => $v) {
            if (in_array($v['rule_id'],$rule_arr)) {
                $data[$k]['str'] = "checked='checked'";
            } else {
                $data[$k]['str'] = "";
            }
        }
        //无限极分类
        $result = createTree($data, 0);
        //dump($result);
        return $result;
    }

    /**
     * 查询所有一级分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    static public function selectFirst()
    {
        $r = db('auth_rule')->where(['rule_status'=>1,'rule_pid'=>0])->order('rule_sort')->select();
        return $r;
    }

    /**
     * 查询全部管理员
     * @return false|\PDOStatement|string|\think\Collection
     */
    static public function selectAccess()
    {
        $access = db('admin')->where('admin_status',1)->paginate(10);
        return $access;
    }

    /**
     * 查询某一管理员的所属组
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     */
    static public function groupByAccess($id)
    {
        $r = db('auth_group_access')->where('uid',$id)->field('group_id')->select();
        $arr = [];
        foreach ($r as $k => $v) {
            $arr[] = $v['group_id'];
        }
        return $arr;
    }

    /**
     * 权限分配修改
     * @param $id
     * @param $ids
     * @return int|string
     */
    static public function updateAccess($id, $ids)
    {
        $arr = explode(',',$ids);
        $data = [];
        foreach ($arr as $v) {
            $data[] = [
                'uid'   =>  $id,
                'group_id'=>$v
            ];
        }

        //删除原有
        db('auth_group_access')->where('uid',$id)->delete();

        $r = CommonService::valueInsert('auth_group_access', $data);
        return $r;
    }
}