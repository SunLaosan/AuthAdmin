<?php
/**
 * Created by PhpStorm.
 * User: 孙洪飞
 * Date: 2018/6/27 0027
 * Time: 13:27
 */

namespace app\admin\model;

use think\Model;
class AuthRule extends Model
{
    protected $user_id;

    /**
     * 构造方法
     * AuthRule constructor.
     * @param array|object $user_id
     * @param array $data
     */
    public function __construct($user_id, $data = [])
    {
        parent::__construct($data);
        $this->user_id = $user_id;
    }
    public function selectList()
    {


    }
}