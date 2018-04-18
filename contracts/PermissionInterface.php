<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8 0008
 * Time: 下午 12:30
 */

namespace Wang\Rabc\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface PermissionInterface
{
    /**
     * 角色
     * @return BelongsToMany
     */
    public function roles():BelongsToMany;
}