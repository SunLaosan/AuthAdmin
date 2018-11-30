<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/29 0029
 * Time: 13:31
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\service\RoleService;
use app\admin\service\CommonService;

class Role extends Base
{
    /**
     * 权限组展示
     * @return mixed
     */
    public function roleGroup()
    {
        $r = RoleService::selectGroup();

        $this->assign('list',$r);
        return $this->fetch();
    }

    /**
     * 权限组名称修改
     * @return \think\response\Json
     */
    public function groupUpdate()
    {
        $title = input('title');
        $id = input('id');
        if(empty($title)) return $this->returnJson(0,'名称不能为空');
        if(empty($id)) return $this->returnJson(0,'未知数据');


        $r = CommonService::valueUpdate('auth_group', ['group_id'=>$id], ['group_title'=>$title]);
        return CommonService::returnJudge($r, '修改权限组名称', '权限组ID:' . $id);
    }

    /**
     * 删除权限组 伪删除
     * @return \think\response\Json
     */
    public function groupDelete()
    {
        $id = input('id');
        if(empty($id)) return $this->returnJson(0,'未知数据');

        $r = CommonService::valueUpdate('auth_group', "group_id in ('" . $id . "')", ['group_status'=>0]);
        return CommonService::returnJudge($r, '删除权限组', '权限组ID:' . $id);
    }

    /**
     * 添加权限组页面渲染
     * @return mixed
     */
    public function groupAdd()
    {
        return $this->fetch();
    }

    /**
     * 添加权限组的处理
     * @return \think\response\Json
     */
    public function groupAddDo()
    {
        $name = input('name');
        if (empty($name)) return $this->returnJson(0,'名称不能为空');

        $r = CommonService::valueInsert('auth_group', ['group_title'=>$name]);
        return CommonService::returnJudge($r, '添加权限组', '权限组ID:' . $r);

    }

    /**
     * 权限分配页面渲染
     * @return mixed
     */
    public function roleNode()
    {
        $r = RoleService::selectGroup();

        $this->assign('list',$r);
        return $this->fetch();
    }

    /**
     * 修改权限页面渲染
     * @return mixed
     */
    public function nodeUpdate()
    {
        $id = input('id');
        if (empty($id)) return $this->error('未知数据');

        $rules = RoleService::selectNode($id);
        $this->assign('id',$id);
        $this->assign('rules',$rules);

        return $this->fetch();
    }

    /**
     * 权限分配给权限组处理
     * @return \think\response\Json
     */
    public function nodeUpdateDo()
    {
        $id = input('id');
        $ids = input('ids');

        if (empty($id)) return $this->returnJson(0,'未知数据');
        if (empty($ids)) return $this->returnJson(0,'权限不能为空');

        $data = [
            'group_rules' => $ids
        ];
        $r = CommonService::valueUpdate('auth_group', ['group_id'=>$id], $data);
        return CommonService::returnJudge($r, '权限组分配权限', '权限组ID:' . $id);
    }

    /**
     * 权限规则展示
     * @return mixed
     */
    public function roleRule()
    {
        $r = RoleService::selectRule();

        $this->assign('list',$r);
        return $this->fetch();
    }

    /**
     * 删除规则  单条删除与批量删除 伪删除
     * @return \think\response\Json
     */
    public function ruleDelete()
    {
        $ids = input('id');
        if(empty($ids)) return $this->returnJson(0,'未知数据');

        $r = CommonService::valueUpdate('auth_rule', "rule_id in ('" . $ids . "')",['rule_status'=>0]);
        return CommonService::returnJudge($r, '删除权限规则', '权限id:' . $ids);
    }

    /**
     * 规则修改的页面渲染
     * @return mixed|void
     */
    public function ruleUpdate()
    {
        $id = input('id');
        if (empty($id)) return $this->error('未知数据');
        $this->assign('id',$id);

        $r = CommonService::valueFind('auth_rule', ['rule_id'=>$id]);
        $this->assign('list',$r);
        //查询一级分类
        $selected = RoleService::selectFirst();
        $this->assign('selected',$selected);

        return $this->fetch();
    }

    /**
     * 规则修改的处理
     * @return \think\response\Json
     */
    public function ruleUpdateDo()
    {
        $title = input('title');
        $name = input('name');//url
        $sort = input('sort');
        $icon = input('icon');
        $pid = input('pid');
        $is_show = input('is_show');
        $id = input('id');

        //url判断重复
        $repeat = CommonService::checkRepeat('auth_rule', ['rule_url'=>$name], 'rule_id != ' . $id);
        if($repeat) return $this->returnJson(0,'URL地址重复');

        if (!$title) return $this->returnJson(0,'名称不能为空');
        if (!$id) return $this->returnJson(0,'未知数据');
        //一级目录不能有url
        if ($pid == 0 && $name) return $this->returnJson(0,'一级目录不可存在URL');
        //一级目录必须有icon
        if ($pid == 0 && empty($icon)) return $this->returnJson(0,'一级目录必须有ICON');
        //二级目录必须有url
        if ($pid != 0 && empty($name)) return $this->returnJson(0,'非一级目录必须有URL');

        $data = [
            'rule_title' =>  $title,
            'rule_url'  =>  $name,
            'rule_sort'  =>  $sort,
            'rule_icon'  =>  $icon,
            'rule_pid'   =>  $pid,
            'rule_isshow'=> $is_show
        ];

        $r = CommonService::valueUpdate('auth_rule', ['rule_id'=>$id], $data);
        return CommonService::returnJudge($r, '权限规则修改', '权限规则ID:' . $id);
    }

    /**
     * 规则添加页面的渲染
     * @return mixed
     */
    public function ruleAdd()
    {
        //查询一级分类
        $selected = RoleService::selectFirst();
        $this->assign('selected',$selected);

        return $this->fetch();
    }

    /**
     * 添加规则的处理
     * @return \think\response\Json
     */
    public function ruleAddDo()
    {
        $title = input('title');
        $name = input('name');//url
        $sort = input('sort');
        $icon = input('icon');
        $pid = input('pid');
        $is_show = input('is_show');

        //url判断重复
        $repeat = CommonService::checkRepeat('auth_rule', ['rule_url'=>$name]);
        if($repeat) return $this->returnJson(0,'URL地址重复');

        if (!$title) return $this->returnJson(0,'名称不能为空');
        //一级目录不能有url
        if ($pid == 0 && $name) return $this->returnJson(0,'一级目录不可存在URL');
        //一级目录必须有icon
        if ($pid == 0 && empty($icon)) return $this->returnJson(0,'一级目录必须有ICON');
        //二级目录必须有url
        if ($pid != 0 && empty($name)) return $this->returnJson(0,'非一级目录必须有URL');

        $data = [
            'rule_title' =>  $title,
            'rule_url'  =>  $name,
            'rule_sort'  =>  $sort,
            'rule_icon'  =>  $icon,
            'rule_pid'   =>  $pid,
            'rule_isshow'=> $is_show
        ];

        $r = CommonService::valueInsert('auth_rule', $data);
        return CommonService::returnJudge($r, '添加权限规则', '权限规则ID:' . $r);
    }

    /**
     * 权限分配  展示管理员
     * @return mixed
     */
    public function roleAccess()
    {
        $r = RoleService::selectAccess();
        $this->assign('list',$r);

        return $this->fetch();
    }

    /**
     * 分配权限组页面渲染
     * @return mixed|string
     */
    public function accessUpdate()
    {
        $id = input('id');
        $name = input('name');
        if (empty($id)) return alert('未知数据');

        $r = RoleService::groupByAccess($id);
        $group = RoleService::selectGroup();

        $this->assign('list',$group);
        $this->assign('r',$r);
        $this->assign('id',$id);
        $this->assign('name',$name);
        return $this->fetch();
    }

    /**
     * 权限分配修改的处理
     * @return \think\response\Json
     */
    public function accessUpdateDo()
    {
        $id = input('id');
        $ids = input('ids');

        if (empty($id)) return $this->returnJson(0,'未知数据');
        if (empty($ids)) return $this->returnJson(0,'请选择权限组');

        $r = RoleService::updateAccess($id, $ids);
        return CommonService::returnJudge($r , '修改权限组对应用户关系', '用户ID:' . $id);
    }
}