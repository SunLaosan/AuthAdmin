<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

//由于检测机制问题，动态注册的性能比路由配置要高一些，尤其是多种请求类型混合定义的时候。此处不再写配置return输出方式.
    //后台路由
    //后台首页
    Route::rule('admin','admin/index/index','GET|POST');
    //登录页
    Route::rule('login','admin/login/login','GET|POST');
    //登录检查
    Route::rule('checklogin','admin/login/checklogin','GET|POST');
    //欢迎页
    Route::rule('welcome','admin/index/welcome','GET|POST');
    //退出登录
    Route::rule('loginout','admin/login/loginout','GET|POST');
    //文件上传
    Route::rule('fileupload','admin/common/fileupload','GET|POST');
    Route::rule('webuploader','admin/common/webuploader','GET|POST');
    //管理员模块
    Route::rule('adminshow','admin/admin/adminshow','GET|POST');
    Route::rule('adminadd','admin/admin/adminadd','GET|POST');
    Route::rule('adminadddo','admin/admin/adminadddo','GET|POST');
    Route::rule('adminupdate','admin/admin/adminupdate','GET|POST');
    Route::rule('adminupdatedo','admin/admin/adminupdatedo','GET|POST');
    Route::rule('admindelete','admin/admin/admindelete','GET|POST');
    //权限模块
    Route::rule('rolegroup','admin/role/rolegroup','GET|POST');
    Route::rule('rolenode','admin/role/rolenode','GET|POST');
    Route::rule('rolerule','admin/role/rolerule','GET|POST');
    Route::rule('groupupdate','admin/role/groupupdate','GET|POST');
    Route::rule('groupdelete','admin/role/groupdelete','GET|POST');
    Route::rule('groupadd','admin/role/groupadd','GET|POST');
    Route::rule('groupadddo','admin/role/groupadddo','GET|POST');

    Route::rule('rolenode','admin/role/rolenode','GET|POST');
    Route::rule('nodeupdate','admin/role/nodeupdate','GET|POST');
    Route::rule('nodeupdatedo','admin/role/nodeupdatedo','GET|POST');

    Route::rule('rolerule','admin/role/rolerule','GET|POST');
    Route::rule('ruledelete','admin/role/ruledelete','GET|POST');
    Route::rule('ruleupdate','admin/role/ruleupdate','GET|POST');
    Route::rule('ruleupdatedo','admin/role/ruleupdatedo','GET|POST');
    Route::rule('ruleadd','admin/role/ruleadd','GET|POST');
    Route::rule('ruleadddo','admin/role/ruleadddo','GET|POST');

    Route::rule('roleaccess','admin/role/roleaccess','GET|POST');
    Route::rule('accessupdate','admin/role/accessupdate','GET|POST');
    Route::rule('accessupdatedo','admin/role/accessupdatedo','GET|POST');
    //配置模块
    Route::rule('config','admin/basic/index','GET|POST');
    Route::rule('configupdatedo','admin/basic/configupdatedo','GET|POST');

    //前台路由
    //Route::rule();


